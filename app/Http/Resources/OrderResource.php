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
            'payment_method' => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            'delivery_option' => new DeliveryOptionResource($this->whenLoaded('deliveryOption')),
            'discount' => $this->discount,
            'subtotal' => $this->calculateSubTotal(),
            'total' => $this->calculateTotal(),
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

        if ($this->deliveryOption) {
            $total += $this->deliveryOption->price;
        }

        return $total - $this->discount;
    }

}
