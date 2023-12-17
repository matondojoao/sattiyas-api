<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Repositories\Customer\reviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(reviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function review(ReviewRequest $request)
    {
        return new ReviewResource($this->reviewRepository->create($request->validated()));
    }
}
