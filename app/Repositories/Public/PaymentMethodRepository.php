<?php

namespace App\Repositories\Public;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Cache;

class PaymentMethodRepository
{

    private $entity;
    private $time = 5;

    public function __construct(PaymentMethod $model)
    {
        $this->entity = $model;
    }

    public function getAllPaymentMethods()
    {
        return Cache::remember('getAllPaymentMethods', $this->time, function () {
            return $this->entity->get();
        });
    }
}
