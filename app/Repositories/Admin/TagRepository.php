<?php

namespace App\Repositories\Admin;

use App\Models\Tag;

class TagRepository
{
    private $entity;

    public function __construct(Tag $model)
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
        $category =$this->entity->findOrFail($id);
        $category->delete();

        return response()->json(['message'=>'Tag deleted successfully']);
    }
}
