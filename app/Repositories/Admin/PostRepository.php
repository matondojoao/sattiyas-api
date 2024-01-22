<?php

namespace App\Repositories\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Traits\TraitRepository;

class PostRepository
{
    private $entity;
    use TraitRepository;

    public function __construct(Post $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        if (isset($data['featured_image'])) {
            $imagePath = $data['featured_image']->store('post_images', 'public');
            $data['featured_image'] = $imagePath;
        }

        return $this->getAuthUser()->create($data);
    }

    public function update(string $id, array $data)
    {
        $post = $this->entity->findOrFail($id);

        if (isset($data['featured_image'])) {
            Storage::disk('public')->delete($post->featured_image);
            $imagePath = $data['featured_image']->store('post_images', 'public');
            $data['featured_image'] = $imagePath;
        }

        $post->update($data);

        return $post;
    }

    public function delete($id)
    {
        $post = $this->entity->findOrFail($id);

        Storage::disk('public')->delete($post->featured_image);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}