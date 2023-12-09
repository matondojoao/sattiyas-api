<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RealStateResource extends JsonResource
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
            'title'=>$this->title,
            'description'=>$this->description,
            'content'=>$this->content,
            'price'=>$this->price,
            'bathrooms'=>$this->bathrooms,
            'badrooms'=>$this->badrooms,
            'property_area'=>$this->property_area,
            'total_property_area'=>$this->total_property_area,
            'categories'=>CategoyResource::collection($this->whenLoaded('categories')),
            'photos'=>RealStatePhotosResource::collection($this->whenLoaded('photos')),
            'address'=>new AddressResource($this->whenLoaded('address')),
            'user'=>new UserResource($this->user),
            'slug'=>$this->slug,
        ];
    }
}
