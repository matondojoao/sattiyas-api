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

    public function getAllProducts($data)
    {
        return Cache::remember('getAllProducts', $this->time, function () use ($data) {
            return $this->entity
                ->with('images', 'colors', 'categories', 'sizes', 'stock', 'reviews.user', 'brand')
                ->where(function ($query) use ($data) {
                    if (isset($data['name'])) {
                        $name = $data['name'];
                        $query->where('name', 'LIKE', "%{$name}%");
                    }

                    if (isset($data['brand'])) {
                        $brand = $data['brand'];
                        $query->where('brand_id', $brand);
                    }

                    if (isset($data['min_price']) && isset($data['max_price'])) {
                        $minPrice = $data['min_price'];
                        $maxPrice = $data['max_price'];
                        $query->whereBetween('regular_price', [$minPrice, $maxPrice]);
                    } elseif (isset($data['min_price'])) {
                        $minPrice = $data['min_price'];
                        $query->where('regular_price', '>=', $minPrice);
                    } elseif (isset($data['max_price'])) {
                        $maxPrice = $data['max_price'];
                        $query->where('regular_price', '<=', $maxPrice);
                    }

                    if (isset($data['categories'])) {
                        $categoryIds = $data['categories'];
                        $query->whereHas('categories', function ($categoryQuery) use ($categoryIds) {
                            $categoryQuery->whereIn('id', $categoryIds);
                        });
                    }

                    if (isset($data['colors'])) {
                        $colorsIds = $data['colors'];
                        $query->whereHas('colors', function ($colorQuery) use ($colorsIds) {
                            $colorQuery->whereIn('id', $colorsIds);
                        });
                    }

                    if (isset($data['sizes'])) {
                        $sizeIds = $data['sizes'];
                        $query->whereHas('sizes', function ($sizeQuery) use ($sizeIds) {
                            $sizeQuery->whereIn('id', $sizeIds);
                        });
                    }
                })
                ->paginate(9);
        });
    }

    public function getProductDetailsBySlug(string $slug)
    {
        return Cache::remember('getProductDetails', $this->time, function () use ($slug) {
            return $this->entity->with('images', 'colors', 'categories', 'sizes', 'stock', 'reviews.user', 'brand')
                ->where('slug', $slug)->first();
        });
    }
}
