<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory, UuidTrait;

    protected $table="delivery_options";

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'description',
        'price'
    ];
}
