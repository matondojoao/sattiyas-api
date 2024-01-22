<?php

namespace App\Repositories\Public;

use App\Models\PostCategory;
use Illuminate\Support\Facades\Cache;

class PostCategoryRepository
{
    private $entity;
    private $time = 5;

    public function __construct(PostCategory $model)
    {
        $this->entity = $model;
    }

    public function getAllCategories()
    {
        return Cache::remember('getAllPostCategories', $this->time, function () {
            return $this->entity->orderBy('created_at', 'asc')->get();
        });
    }
}
