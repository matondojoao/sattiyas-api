<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Repositories\Public\PaymentMethodRepository;

class PaymentMethodController extends Controller
{
    protected $PaymentMethodRepository;

    public function __construct(PaymentMethodRepository $PaymentMethodRepository)
    {
        $this->PaymentMethodRepository = $PaymentMethodRepository;
    }

    public function index()
    {
        $paymentMethods = $this->PaymentMethodRepository->getAllPaymentMethods();

        return PaymentMethodResource::collection($paymentMethods);
    }
}
