<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetStockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = $this->getProduct();

        return [
            'id' => $this->id,
            'product' => $product->name ?? null,
            'status' => $this->getStatus(),
            'stock_units' => $this->quantity,
        ];
    }

    protected function getProduct()
    {
        return \App\Models\Product::find($this->product_id);
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
