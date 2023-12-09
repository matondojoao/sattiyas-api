<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';


    protected $fillable = [
        'code',
        'type',
        'value',
    ];

    /**
     * The roles that belong to the Promotion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user', 'promotion_id', 'user_id')
            ->withTimestamps();
    }
}
