<?php

namespace App\Repositories\Public;

use App\Models\Size;
use Illuminate\Support\Facades\Cache;

class SizeRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Size $model)
    {
        $this->entity = $model;
    }

    public function getAllSizes()
    {
        return Cache::remember('getAllSizes', $this->time, function () {
            return $this->entity->get();
        });
    }
}
