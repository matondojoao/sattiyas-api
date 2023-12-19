<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Repositories\Public\CouponRepository;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function applyCoupon(CouponRequest $request)
    {
        return $this->couponRepository->applyCouponCode($request->validated());
    }
}
