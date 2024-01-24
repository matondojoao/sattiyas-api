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

    public function all($data)
    {
        $query = $this->entity->with('categories', 'tags');

        if (isset($data['categories'])) {
            $categoryIds = $data['categories'];
            $query->whereHas('categories', function ($categoryQuery) use ($categoryIds) {
                $categoryQuery->whereIn('id', $categoryIds);
            });
        }

        if (isset($data['tags'])) {
            $tagIds = $data['tags'];
            $query->whereHas('tags', function ($tagQuery) use ($tagIds) {
                $tagQuery->whereIn('id', $tagIds);
            });
        }
        return $query->paginate(8);
    }

    public function details($slug)
    {
        return $this->entity->with('comments')->where('slug', $slug)->first();
    }
}
