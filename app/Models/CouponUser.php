<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory, UuidTrait;

    protected $table="coupon_user";

    public $incrementing = false;

    protected $keyType = 'uuid';
}
