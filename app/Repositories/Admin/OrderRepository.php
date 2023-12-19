<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class OrderRepository
{
    private $entity;

    public function __construct(Order $model)
    {
        $this->entity = $model;
    }

    public function getSalesReport($data)
    {
        $query = $this->entity->with('orderItems')->where(function ($query) use ($data) {
            if (isset($data['date']) && $data['date'] == 'year') {
                $query->orWhereYear('created_at', now()->year);
            }

            if (isset($data['date']) && $data['date'] == 'last_month') {
                $query->orWhereMonth('created_at', now()->subMonth()->month);
            }

            if (isset($data['date']) && $data['date'] == 'this_month') {
                $query->orWhereMonth('created_at', now()->month);
            }

            if (isset($data['date']) && $data['date'] == 'last_seven_days') {
                $query->orWhere('created_at', '>=', now()->subDays(7));
            }

            if (isset($data['start_date']) && isset($data['end_date']) && (!isset($data['date']) || $data['date'] !== 'date_range')) {
                $query->orWhereBetween('created_at', [$data['start_date'], $data['end_date']]);
            }

            if (isset($data['start_date']) && (!isset($data['date']) || $data['date'] !== 'start_date')) {
                $query->orWhere('created_at', '>=', $data['start_date']);
            }

            if (isset($data['end_date']) && (!isset($data['date']) || $data['date'] !== 'end_date')) {
                $query->orWhere('created_at', '<=', $data['end_date']);
            }
        });

        $orders = $query->get();

        $result = [];
        $totalOrders = $orders->count();

        foreach ($orders as $order) {
            $totalGrossSales = 0;
            $totalNetSales = 0;
            $totalItems = 0;

            foreach ($order->orderItems as $item) {
                $totalGrossSales += $item->price * $item->quantity;
                $totalItems += $item->quantity;
            }

            $discount = $order->discount ?? 0;
            $totalNetSales = $totalGrossSales - $discount;

            if (isset($data['date']) && $data['date'] == 'year') {
                $yearKey = $order->created_at->format('Y');
                $result[$yearKey]['total_gross_sales'] = ($result[$yearKey]['total_gross_sales'] ?? 0) + $totalGrossSales;
                $result[$yearKey]['total_net_sales'] = ($result[$yearKey]['total_net_sales'] ?? 0) + $totalNetSales;
                $result[$yearKey]['total_items'] = ($result[$yearKey]['total_items'] ?? 0) + $totalItems;
                $result[$yearKey]['total_orders']=$totalOrders;

            }

            if (isset($data['date']) && in_array($data['date'], ['this_month', 'last_month'])) {
                $monthKey = $order->created_at->format('Y-m');
                $result[$monthKey]['total_gross_sales'] = ($result[$monthKey]['total_gross_sales'] ?? 0) + $totalGrossSales;
                $result[$monthKey]['total_net_sales'] = ($result[$monthKey]['total_net_sales'] ?? 0) + $totalNetSales;
                $result[$monthKey]['total_items'] = ($result[$monthKey]['total_items'] ?? 0) + $totalItems;
                $result[$monthKey]['total_orders']=$totalOrders;
            }

            if (isset($data['date']) && $data['date'] == 'last_seven_days') {
                $weekKey = $order->created_at->startOfWeek()->format('Y-m-d');
                $result[$weekKey]['total_gross_sales'] = ($result[$weekKey]['total_gross_sales'] ?? 0) + $totalGrossSales;
                $result[$weekKey]['total_net_sales'] = ($result[$weekKey]['total_net_sales'] ?? 0) + $totalNetSales;
                $result[$weekKey]['total_items'] = ($result[$weekKey]['total_items'] ?? 0) + $totalItems;
                $result[$weekKey]['total_orders']=$totalOrders;
            }

            if (isset($data['date']) && $data['date'] == 'date_range') {
                $startDate = Carbon::parse($data['start_date']);
                $endDate = Carbon::parse($data['end_date']);

                while ($startDate->lte($endDate)) {
                    $dateKey = $startDate->format('Y-m-d');
                    $result[$dateKey]['total_gross_sales'] = ($result[$dateKey]['total_gross_sales'] ?? 0) + $totalGrossSales;
                    $result[$dateKey]['total_net_sales'] = ($result[$dateKey]['total_net_sales'] ?? 0) + $totalNetSales;
                    $result[$dateKey]['total_items'] = ($result[$dateKey]['total_items'] ?? 0) + $totalItems;
                    $result[$dateKey]['total_orders']=$totalOrders;
                    $startDate->addDay();
                }
            }
        }

        foreach ($result as $key => &$data) {
            $data['average_monthly_sales'] = $data['total_gross_sales'] / $totalOrders;
        }

        return response()->json([
            'result' => $result,
        ]);
    }

    public function all()
    {
        return $this->entity->orderBy()->get();
    }

    public function find(string $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $order = $this->entity->findOrFail($id);
        $order->update($data);

        $pdf = PDF::loadView('order.invoice', ['order' => $order]);

        $pdfPath = storage_path('app/public/order_' . $order->id . '.pdf');
        $pdf->save($pdfPath);

        $fulfillmentStatus = '';

        if ($order->fulfillment_status == 'pending') {
            $fulfillmentStatus = 'Pendente';
        } else if ($order->fulfillment_status == 'processing') {
            $fulfillmentStatus = 'Processando';
        } else if ($order->fulfillment_status == 'completed')
            $fulfillmentStatus = 'Completo';
        else {
            $fulfillmentStatus = 'Cancelado';
        }

        $order->user->notify(new OrderStatusChangedNotification($pdfPath, $order, $fulfillmentStatus));

        return $order;
    }

    public function delete($id)
    {
        $category = $this->entity->findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
