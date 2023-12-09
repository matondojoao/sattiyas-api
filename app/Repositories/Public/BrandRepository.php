<?php

namespace App\Repositories\Public;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Brand $model)
    {
        $this->entity = $model;
    }

    public function getAllBrands()
    {
        return Cache::remember('getAllBrands', $this->time, function () {
            return $this->entity->get();
        });
    }
}
