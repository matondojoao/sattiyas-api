<?php

namespace App\Repositories\Admin;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageRespoitory
{
    private $entity;

    public function __construct(ProductImage $model)
    {
        $this->entity = $model;
    }

    public function deleteImageById(string $id)
    {
        $image = $this->entity->findOrFail($id);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
