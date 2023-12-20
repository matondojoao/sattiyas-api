<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'number_of_orders' => $this->orders->count(),
            'total_spent' => $this->calculateTotalSpent(),
            'last_order' => $this->getLastOrder(),
        ];
    }

    public function getLastOrder()
    {
        $lastOrder = $this->orders()->latest()->first();

        return $lastOrder ? $lastOrder->created_at : null;
    }


    public function calculateTotalSpent()
    {
        return $this->orders->sum(function ($order) {
            return $order->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
            }) - ($order->discount ?? 0);
        });
    }
}
