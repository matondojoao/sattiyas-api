<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'company_name',
        'country_region',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'email_address',
        'order_notes',
        'house_number_and_street',
        'apartment_suite_optional',
        'payment_status',
        'fulfillment_status',
        'delivery_option_id',
        'payment_method_id',
        'discount'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deliveryOption that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryOption()
    {
        return $this->belongsTo(DeliveryOption::class);
    }
}
