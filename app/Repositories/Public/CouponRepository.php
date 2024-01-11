<?php

namespace App\Repositories\Public;

class CouponRepository
{
    public function applyCouponCode(array $data)
    {
        $coupon = \App\Models\Promotion::where('code', $data['code'])->first();

        if ($coupon) {
            if ($coupon->type == "fixed_amount") {
                return response()->json(['code' => $coupon->code ,'type' => 'amount', 'value' => $coupon->value]);

            } elseif ($coupon->type == "percentage") {
                return response()->json(['code' => $coupon->code, 'percentage', 'value' => $coupon->value]);
            }
        }
    }
}
