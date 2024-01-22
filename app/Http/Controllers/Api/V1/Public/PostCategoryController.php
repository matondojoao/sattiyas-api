<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCategoryResource;
use App\Repositories\Public\PostCategoryRepository;

class PostCategoryController extends Controller
{
    private $repository;

    public function __construct(PostCategoryRepository $CategoryRepository)
    {
        $this->repository = $CategoryRepository;
    }
    public function index()
    {
        return PostCategoryResource::collection($this->repository->getAllCategories());
    }
}
