<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->create($data);

        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $category = $this->categoryRepository->update($id, $data);

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
