<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderRepository
{
    private $entity;

    public function __construct(Order $model)
    {
        $this->entity = $model;
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
