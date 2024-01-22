<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'author' => $this->user,
            'title' => $this->title,
            'content' => $this->content,
            'featured_image' => $this->featured_image ? url('storage/' . $this->featured_image) : null,
            'created_at' => $this->created_at,
        ];
    }
}
