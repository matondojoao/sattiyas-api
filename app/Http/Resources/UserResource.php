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
            'photo_path' => $this->photo_path,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            'alternative_phone' => $this->alternative_phone,
            'gender' => $this->gender,
            'role' => $this->role,
            'shipping_address'=>new ShippingAddressResource($this->whenLoaded('shippingAddress')),
            'billing_address'=>new ShippingAddressResource($this->whenLoaded('billingAddress'))
        ];
    }
}
