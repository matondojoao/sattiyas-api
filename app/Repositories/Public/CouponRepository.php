<?php

namespace App\Repositories\Public;

class CouponRepository
{
    public function applyCouponCode(array $data)
    {
        $coupon = \App\Models\Promotion::where('code', $data['code'])->first();

        if ($coupon) {
            if ($coupon->type == "fixed_amount") {
                session()->put('coupon', ['code' => $data['code'],'type' => 'amount', 'value' => $coupon->value]);
            } elseif ($coupon->type == "percentage") {
                session()->put('coupon', ['code' => $data['code'],'type' => 'percentage', 'value' => $coupon->value]);
            }

            return response()->json(['message' => 'Coupon applied successfully']);
        }

        return response()->json(['message' => 'Invalid or not found coupon']);
    }
}
