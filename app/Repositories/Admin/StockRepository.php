<?php

namespace App\Repositories\Admin;

use App\Models\Stock;
use Illuminate\Support\Facades\Cache;

class StockRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Stock $model)
    {
        $this->entity = $model;
    }

    public function getStocks(array $data)
    {
        return Cache::remember('getStocks', $this->time, function () use ($data) {
            $query = $this->entity->where(function ($query) use ($data) {
                if (isset($data['status']) && $data['status'] == 'in_stock') {
                    $query->where('quantity', '>=', 10);
                }

                if (isset($data['status']) && $data['status'] == 'low_stock') {
                    $query->orWhere(function ($query) {
                        $query->where('quantity', '>', 0)->where('quantity', '<', 10);
                    });
                }

                if (isset($data['status']) && $data['status'] == 'out_of_stock') {
                    $query->orWhere(function ($query) {
                        $query->where('quantity', '<=', 0);
                    });
                }
            });

            return $query->paginate(10);
        });
    }
}
