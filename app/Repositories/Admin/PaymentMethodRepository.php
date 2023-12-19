<?php

namespace App\Repositories\Admin;

use App\Models\PaymentMethod;

class PaymentMethodRepository
{
    private $entity;

    public function __construct(PaymentMethod $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id,array $data)
    {
        $PaymentMethod = $this->entity->findOrFail($id);
        $PaymentMethod->update($data);

        return $PaymentMethod;
    }

    public function delete($id)
    {
        $PaymentMethod = $this->entity->findOrFail($id);
        $PaymentMethod->delete();

        return response()->json(['message'=>'Payment method option deleted successfully']);
    }
}
