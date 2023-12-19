<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Repositories\Admin\PaymentMethodRepository;

class PaymentMethodController extends Controller
{
    protected $PaymentMethodRepository;

    public function __construct(PaymentMethodRepository $PaymentMethodRepository)
    {
        $this->PaymentMethodRepository = $PaymentMethodRepository;
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $data = $request->validated();
        $paymentMethod = $this->PaymentMethodRepository->create($data);

        return new PaymentMethodResource($paymentMethod);
    }

    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $data = $request->all();
        $paymentMethod = $this->PaymentMethodRepository->update($id, $data);

        return new PaymentMethodResource($paymentMethod);
    }

    public function destroy($id)
    {
        return $this->PaymentMethodRepository->delete($id);
    }
}
