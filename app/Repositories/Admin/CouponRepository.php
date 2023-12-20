<?php

namespace App\Repositories\Admin;

use App\Models\Promotion;
use Illuminate\Support\Facades\Cache;

class CouponRepository
{
    private $entity;

    public function __construct(Promotion $model)
    {
        $this->entity = $model;
    }

    public function index()
    {

        return Cache::remember('getCoupons', 5, function() {
            return $this->entity->paginate();
        });
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id,array $data)
    {
        $coupon = $this->entity->findOrFail($id);
        $coupon->update($data);

        return $coupon;
    }

    public function delete($id)
    {
        $coupon = $this->entity->findOrFail($id);
        $coupon->delete();

        return response()->json(['message'=>'Coupon deleted successfully']);
    }
}
