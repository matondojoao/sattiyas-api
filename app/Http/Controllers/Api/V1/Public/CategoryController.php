<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Repositories\Public\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->repository = $CategoryRepository;
    }
    public function index()
    {
        return $this->repository->getAllCategories();
    }

    public function getProducts($id)
    {
        return ProductResource::collection($this->repository->getProductsByCategoryId($id));
    }
}
