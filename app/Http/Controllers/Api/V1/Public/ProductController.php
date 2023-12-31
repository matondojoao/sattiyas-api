<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\Public\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->repository = $ProductRepository;
    }

    public function index(Request $request)
    {
        return ProductResource::collection($this->repository->getAllProducts($request->all()));
    }

    public function show($slug)
    {
        $product = $this->repository->getProductDetailsBySlug($slug);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $relatedProducts = $product->relatedProducts->toArray();
        $relatedProducts = array_values($relatedProducts);

        return response()->json([
            'data' => [
                'product' => new ProductResource($product),
                'relatedProducts' => $relatedProducts,
            ]
        ]);
    }

    public function getMinMaxPrices()
    {
        $prices = $this->repository->getMinMaxPrices();

        return response()->json($prices);
    }
}
