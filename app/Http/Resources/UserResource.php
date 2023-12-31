<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'phone' => $this->phone,
            'alternative_phone' => $this->alternative_phone,
            'gender' => $this->gender,
            'photo_path' =>$this->photo_path ? url('storage/' . $this->photo_path) : null,
            'shipping_address'=>new ShippingAddressResource($this->whenLoaded('shippingAddress')),
            'billing_address'=>new ShippingAddressResource($this->whenLoaded('billingAddress'))
        ];
    }
}
