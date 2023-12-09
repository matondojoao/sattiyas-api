<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'body' => $this->body,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'shipping_type' => $this->shipping_type,
            'delivery' => $this->delivery,
            'slug' => $this->slug,
            'product_id_type' => $this->product_id_type,
            'product_id' => $this->product_id,
            'expiry_date_of_product' => $this->expiry_date_of_product,
            'sku' => $this->sku,
            'is_featured' => $this->is_featured,
            'manufacturer' => $this->manufacturer,
            'weight' => $this->weight,
            'attributes' => $this->attributes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'colors' => ColorResource::collection($this->whenLoaded('colors')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'sizes' => SizeResource::collection($this->whenLoaded('sizes')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'stock' => new StockResource($this->whenLoaded('stock')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
