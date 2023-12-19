<?php

namespace App\Repositories\Admin;

use App\Models\Category;

class CategoryRepository
{
    private $entity;

    public function __construct(Category $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id,array $data)
    {
        $category = $this->entity->findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message'=>'Category deleted successfully']);
    }
}
