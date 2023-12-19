<?php

namespace App\Repositories\Admin;

use App\Models\DeliveryOption;

class DeliveryOptionRepository
{
    private $entity;

    public function __construct(DeliveryOption $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id,array $data)
    {
        $deliveryOption = $this->entity->findOrFail($id);
        $deliveryOption->update($data);

        return $deliveryOption;
    }

    public function delete($id)
    {
        $deliveryOption = $this->entity->findOrFail($id);
        $deliveryOption->delete();

        return response()->json(['message'=>'Delivery option deleted successfully']);
    }
}
