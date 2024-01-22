<?php

namespace App\Repositories\Public;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Traits\TraitRepository;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    private $entity;
    use TraitRepository;

    public function __construct(Post $model)
    {
        $this->entity = $model;
    }

    public function all()
    {

        $posts = Cache::remember('getAllPosts', now()->addMinutes(10), function () {
            return $this->entity->all();
        });

        return $posts;
    }

    public function details($id)
    {
        return $this->entity->with('comments')->findOrFail($id);
    }
}
