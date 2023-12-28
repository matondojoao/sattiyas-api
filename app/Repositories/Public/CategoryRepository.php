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

                $categoryData = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'parent_id' => $category->parent_id,
                    'subcategories' => [],
                ];

                $organizedCategories[$parent_id][] = $categoryData;
            }

            foreach ($categories as $category) {
                $categoryData = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'parent_id' => $category->parent_id,
                    'subcategories' => $organizedCategories[$category->id] ?? [],
                ];

                $organizedCategories[$parent_id][] = $categoryData;
            }

            return $organizedCategories['root'] ?? [];
        });
    }


    public function getProductsByCategoryId(string $id)
    {
        return Cache::remember('getProductsByCategoryId', $this->time, function () use ($id) {
            return $this->entity->findOrFail($id)->products;
        });
    }
}
