<?php

namespace App\Repositories\Public;

use App\Models\DeliveryOption;
use Illuminate\Support\Facades\Cache;

class DeliveryOptionRepository
{

    private $entity;
    private $time = 5;

    public function __construct(DeliveryOption $model)
    {
        $this->entity = $model;
    }

    public function getAllDeliveryOptions()
    {
        return Cache::remember('getAllDeliveryOptions', $this->time, function () {
            return $this->entity->get();
        });
    }
}
