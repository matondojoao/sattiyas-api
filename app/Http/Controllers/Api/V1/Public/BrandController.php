<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Repositories\Public\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $repository;

    public function __construct(BrandRepository $CategoryRepository)
    {
        $this->repository = $CategoryRepository;
    }
    public function index()
    {
        return BrandResource::collection($this->repository->getAllBrands());
    }
}
