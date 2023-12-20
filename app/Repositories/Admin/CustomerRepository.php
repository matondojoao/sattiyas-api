<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class CustomerRepository
{
    private $entity;

    public function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function getCustomersReport($data)
    {
        $query = $this->entity->where(function ($query) use ($data) {
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

        $customers = $query->get();

        $result = [];

        foreach ($customers as $customer) {
            $registrationsPeriod = 1;

            if (isset($data['date']) && $data['date'] == 'year') {
                $yearKey = $customer->created_at->format('Y');
                $result[$yearKey]['registrations_in_this_period'] = ($result[$yearKey]['registrations_in_this_period'] ?? 0) + $registrationsPeriod;
            }

            if (isset($data['date']) && in_array($data['date'], ['this_month', 'last_month'])) {
                $monthKey = $customer->created_at->format('Y-m');
                $result[$monthKey]['registrations_in_this_period'] = ($result[$monthKey]['registrations_in_this_period'] ?? 0) + $registrationsPeriod;
            }

            if (isset($data['date']) && $data['date'] == 'last_seven_days') {
                $weekKey = $customer->created_at->startOfWeek()->format('Y-m-d');
                $result[$weekKey]['registrations_in_this_period'] = ($result[$weekKey]['registrations_in_this_period'] ?? 0) + $registrationsPeriod;
            }

            if (isset($data['date']) && $data['date'] == 'date_range') {
                $startDate = Carbon::parse($data['start_date']);
                $endDate = Carbon::parse($data['end_date']);

                while ($startDate->lte($endDate)) {
                    $dateKey = $startDate->format('Y-m-d');
                    $result[$dateKey]['registrations_in_this_period'] = ($result[$dateKey]['registrations_in_this_period'] ?? 0) + $registrationsPeriod;
                    $startDate->addDay();
                }
            }
        }

        return Response::json([
            'customersResult' => $result,
        ]);
    }

    public function delete($id)
    {
        $customer = $this->entity->findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
