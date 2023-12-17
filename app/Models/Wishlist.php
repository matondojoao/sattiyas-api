<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory, UuidTrait;

    protected $table="wishlists";

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable=['product_id'];

    /**
     * Get all of the products for the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    /**
     * Get the user that owns the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
