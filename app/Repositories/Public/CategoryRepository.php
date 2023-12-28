<?php

namespace App\Repositories\Public;

use App\Http\Resources\CategoryResource;
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
        $categories = $this->entity->get();

        $organizedCategories = [];

        foreach ($categories as $category) {
            $parent_id = $category->parent_id ?: 'root';

            if (!isset($organizedCategories[$parent_id])) {
                $organizedCategories[$parent_id] = [];
            }

            $categoryResource = new CategoryResource($category);
            $categoryResource->subcategories = collect();

            $organizedCategories[$parent_id][] = $categoryResource;
        }

        foreach ($categories as $category) {
            $categoryResource = new CategoryResource($category);

            if (isset($organizedCategories[$category->id])) {
                $categoryResource->subcategories = collect($organizedCategories[$category->id]);
            }

            $organizedCategories[$parent_id][] = $categoryResource;
        }

        return collect($organizedCategories['root'] ?? []);
    });
}

    public function getProductsByCategoryId(string $id)
    {
        return Cache::remember('getProductsByCategoryId', $this->time, function () use ($id) {
            return $this->entity->findOrFail($id)->products;
        });
    }
}
