<?php

namespace App\Repositories\Admin;

use App\Models\Order;

class OrderRepository
{
    private $entity;

    public function __construct(Order $model)
    {
        $this->entity = $model;
    }

    public function all()
    {
        return $this->entity->orderBy()->get();
    }

    public function find(string $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $order = $this->entity->findOrFail($id);
        $order->update($data);

        return $order;
    }

    public function delete($id)
    {
        $category =$this->entity->findOrFail($id);
        $category->delete();

        return response()->json(['message'=>'Order deleted successfully']);
    }
}
