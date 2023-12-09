<?php

namespace App\Repositories\Public;

use App\Models\Module;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    private $entity;
    private $time = 5;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    public function getAllProducts()
    {
        return Cache::remember('getAllProducts', $this->time, function () {
            return $this->entity->with('images', 'colors', 'categories', 'sizes', 'stock', 'reviews.user', 'brand')
                ->paginate(9);
        });
    }

    public function getProductDetailsBySlug(string $slug)
    {
        return Cache::remember('getProductDetails', $this->time, function () use($slug){
            return $this->entity->with('images', 'colors', 'categories', 'sizes', 'stock', 'reviews.user', 'brand')
                ->where('slug', $slug)->first();
        });
    }
}
