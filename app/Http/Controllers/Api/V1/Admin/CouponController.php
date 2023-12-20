<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Repositories\Admin\CouponRepository;

class CouponController extends Controller
{
    protected $CouponRepository;

    public function __construct(CouponRepository $CouponRepository)
    {
        $this->CouponRepository = $CouponRepository;
    }

    public function index()
    {
        $coupons = $this->CouponRepository->index();

        return CouponResource::collection($coupons);
    }
    public function store(StoreCouponRequest $request)
    {
        $data = $request->validated();
        $coupon = $this->CouponRepository->create($data);

        return new CouponResource($coupon);
    }

    public function update(UpdateCouponRequest $request, $id)
    {
        $data = $request->all();
        $coupon = $this->CouponRepository->update($id, $data);

        return new CouponResource($coupon);
    }

    public function destroy($id)
    {
        return $this->CouponRepository->delete($id);
    }
}
