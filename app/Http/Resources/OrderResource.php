<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'payment_status' => $this->payment_status,
            'fulfillment_status' => $this->fulfillment_status,
            'user' => new UserResource($this->whenLoaded('user')),
            'payment_method' => new UserResource($this->whenLoaded('user')),
            'delivery_option' => new UserResource($this->whenLoaded('deliveryOption')),
            'discount' => $this->discount,
            'subtotal' => $this->calculateSubTotal(),
            //'total' => $this->calculateTotal() - $this->discount,
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }

    private function calculateSubTotal()
    {
        $total = 0;

        foreach ($this->orderItems as $item) {
            $total += $item->price * $item->quantity;
        }


        return $total;
    }
    private function calculateTotal()
    {
        $total = 0;

        foreach ($this->orderItems as $item) {
            $total += $item->price * $item->quantity;
        }

        foreach ($this->deliveryOption as $Option) {
            $total += $Option?->price;
        }


        return $total;
    }
}
