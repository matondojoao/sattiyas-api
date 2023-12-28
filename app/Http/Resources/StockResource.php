<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'status' => $this->getStatus(),
            'stock_units' => $this->quantity,
        ];
    }

    protected function getStatus()
    {
        if ($this->quantity <= 0) {
            return 'Out of stock';
        } elseif ($this->quantity > 0 && $this->quantity < 10) {
            return 'Low stock';
        } else {
            return 'In stock';
        }
    }
}
