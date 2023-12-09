<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\Public\ProductRepository;

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->repository = $ProductRepository;
    }

    public function index()
    {
        return ProductResource::collection($this->repository->getAllProducts());
    }

    public function show($slug)
    {
        return new ProductResource($this->repository->getProductDetailsBySlug($slug));
    }
}
