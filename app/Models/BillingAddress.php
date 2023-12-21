<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory, UuidTrait;

    protected $table="billing_address";

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'address',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state',
        'zip_code'
        ];

    /**«
     * Get the user that owns the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
