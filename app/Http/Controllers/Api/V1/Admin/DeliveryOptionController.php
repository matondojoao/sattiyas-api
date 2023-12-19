<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryOptionRequest;
use App\Http\Requests\UpdateDeliveryOptionRequest;
use App\Http\Resources\DeliveryOptionResource;
use App\Repositories\Admin\DeliveryOptionRepository;

class DeliveryOptionController extends Controller
{
    protected $DeliveryOptionRepository;

    public function __construct(DeliveryOptionRepository $DeliveryOptionRepository)
    {
        $this->DeliveryOptionRepository = $DeliveryOptionRepository;
    }

    public function store(StoreDeliveryOptionRequest $request)
    {
        $data = $request->validated();
        $deliveryOption = $this->DeliveryOptionRepository->create($data);

        return new DeliveryOptionResource($deliveryOption);
    }

    public function update(UpdateDeliveryOptionRequest $request, $id)
    {
        $data = $request->all();
        $deliveryOption = $this->DeliveryOptionRepository->update($id, $data);

        return new DeliveryOptionResource($deliveryOption);
    }

    public function destroy($id)
    {
        return $this->DeliveryOptionRepository->delete($id);
    }
}
