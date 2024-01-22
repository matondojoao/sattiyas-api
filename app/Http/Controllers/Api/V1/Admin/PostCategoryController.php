<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\PostCategoryResource;
use App\Repositories\Admin\PostCategoryRepository;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(PostCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->create($data);

        return new PostCategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $category = $this->categoryRepository->update($id, $data);

        return new PostCategoryResource($category);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
