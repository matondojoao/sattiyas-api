<?php

namespace App\Repositories\Public;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TagRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Tag $model)
    {
        $this->entity = $model;
    }

    public function getAllCategories()
    {
        return Cache::remember('getAllTags', $this->time, function () {
            return $this->entity->orderBy('created_at', 'asc')->get();
        });
    }
}
