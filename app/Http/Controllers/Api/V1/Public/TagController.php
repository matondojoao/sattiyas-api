<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Repositories\Public\TagRepository;

class TagController extends Controller
{
    private $repository;

    public function __construct(TagRepository $TagRepository)
    {
        $this->repository = $TagRepository;
    }
    public function index()
    {
        return TagResource::collection($this->repository->getAllTags());
    }
}
