<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use App\Repositories\Public\ColorRepository;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    private $repository;

    public function __construct(ColorRepository $ColorRepository)
    {
        $this->repository = $ColorRepository;
    }
    public function index()
    {
        return ColorResource::collection($this->repository->getAllColors());
    }
}
