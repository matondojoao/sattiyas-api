<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::where('email', $this->author_email)->first();

        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'author_name' => $this->author_name,
            'author_email' => $this->author_email,
            'content' => $this->content,
            'photo_path' => $user ? url('storage/' .$user->photo_path) : null,
            'created_at' => $this->created_at,
        ];
    }
}
