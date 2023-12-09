<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Repositories\Public\SizeRepository;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    private $repository;

    public function __construct(SizeRepository $SizeRepository)
    {
        $this->repository = $SizeRepository;
    }
    public function index()
    {
        return SizeResource::collection($this->repository->getAllSizes());
    }
}
