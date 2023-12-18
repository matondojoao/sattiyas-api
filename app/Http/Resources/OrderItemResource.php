<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product' =>new ProductResource($this->whenLoaded('product')),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subtotal' => $this->price * $this->quantity,
        ];
    }
}
