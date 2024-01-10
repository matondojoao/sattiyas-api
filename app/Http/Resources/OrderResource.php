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
            'name' => $this->name,
            'company_name' => $this->company_name,
            'country_region' => $this->country_region,
            'address' => $this->address,
            'house_number_and_street' => $this->house_number_and_street,
            'apartment_suite_optional' => $this->apartment_suite_optional,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email_address' => $this->email_address,
            'order_notes' => $this->order_notes,
            'payment_status' => $this->payment_status,
            'fulfillment_status' => $this->fulfillment_status,
            'requester' => new UserResource($this->whenLoaded('user')),
            'delivery_option' => new DeliveryOptionResource($this->whenLoaded('deliveryOption')),
            'discount' => $this->discount,
            'subtotal' => $this->calculateSubTotal(),
            'total' => $this->calculateTotal(),
            'created_at'=> $this->created_at,
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
