<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    private $entity;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    public function createProduct(array $data)
    {
        return DB::transaction(function () use ($data) {
            $quantity = isset($data['quantity']) ? $data['quantity'] : 1;

            unset($data['quantity']);

            $product = $this->entity->create($data);

            $product->stock()->create(['quantity' => $quantity]);

            if (isset($data['categories']) && count($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            if (isset($data['sizes']) && count($data['sizes'])) {
                $product->sizes()->sync($data['sizes']);
            }

            if (isset($data['colors']) && count($data['colors'])) {
                $product->colors()->sync($data['colors']);
            }

            if (isset($data['images'])) {
                $imagesUploaded = [];

                foreach ($data['images'] as $image) {
                    $path = $image->store('products', 'public');
                    $imagesUploaded[] = ['image_path' => $path, 'is_primary' => false];
                }

                $product->images()->createMany($imagesUploaded);
            }

            $product->load('categories', 'sizes', 'colors', 'images','stock','brand');

            return $product;
        });
    }
    public function updateProduct(array $data, $productId)
    {
        return DB::transaction(function () use ($data, $productId) {
            $product = $this->entity->findOrFail($productId);

            if (isset($data['quantity'])) {
                $product->stock()->increment('quantity', $data['quantity']);
                unset($data['quantity']);
            }

            $product->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            if (isset($data['sizes']) && count($data['sizes'])) {
                $product->sizes()->sync($data['sizes']);
            }

            if (isset($data['colors']) && count($data['colors'])) {
                $product->colors()->sync($data['colors']);
            }

            if (isset($data['images'])) {
                $product->images()->delete();

                $imagesUploaded = [];
                foreach ($data['images'] as $image) {
                    $path = $image->store('products', 'public');
                    $imagesUploaded[] = ['image_path' => $path, 'is_primary' => false];
                }
                $product->images()->createMany($imagesUploaded);
            }

            $product->load('categories', 'sizes', 'colors', 'images', 'stock', 'brand');

            return $product;
        });
    }

    public function delete($id)
    {
        $product = $this->entity->findOrFail($id);
        $product->delete();

        return response()->json(['message'=>'Product deleted successfully']);
    }
}
