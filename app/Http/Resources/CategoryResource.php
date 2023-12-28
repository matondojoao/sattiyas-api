<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'product_count' => $this->getTotalProductCount(),
            'subcategories' => CategoryResource::collection($this->whenLoaded('subcategories')),
        ];
    }

    protected function getTotalProductCount()
    {
        $totalCount = $this->products()->count();

        // foreach ($this->subcategories as $subcategory) {
        //     $totalCount += $subcategory->getTotalProductCount();
        // }

        return $totalCount;
    }
}
