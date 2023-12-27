<?php

namespace App\Repositories\Public;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Category $model)
    {
        $this->entity = $model;
    }

    public function getAllCategories()
    {
        return Cache::remember('getAllCategories', $this->time, function () {
            return $this->entity->get();
        });
    }

    public function getProductsByCategoryId(string $id)
    {
        return Cache::remember('getProductsByCategoryId', $this->time, function () use ($id) {
            return $this->entity->find($id)->products;
        });
    }
}
