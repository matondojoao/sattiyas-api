<?php

namespace App\Repositories\Public;

use App\Models\Color;
use Illuminate\Support\Facades\Cache;

class ColorRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Color $model)
    {
        $this->entity = $model;
    }

    public function getAllColors()
    {
        return Cache::remember('getAllColors', $this->time, function () {
            return $this->entity->get();
        });
    }
}
