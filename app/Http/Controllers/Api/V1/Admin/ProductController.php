<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $ProductRepository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->ProductRepository->createProduct($data);

        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = $this->ProductRepository->updateProduct($id, $data);

        return new ProductResource($product);
    }

    public function destroy($id)
    {
        return $this->ProductRepository->delete($id);
    }
}
