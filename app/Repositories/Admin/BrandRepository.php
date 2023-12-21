<?php

namespace App\Repositories\Admin;

use App\Models\Brand;

class BrandRepository
{
    private $entity;

    public function __construct(Brand $model)
    {
        $this->entity = $model;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id,array $data)
    {
        $brand = $this->entity->findOrFail($id);
        $brand->update($data);

        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->entity->findOrFail($id);
        $brand->delete();

        return response()->json(['message'=>'Brand deleted successfully']);
    }
}
