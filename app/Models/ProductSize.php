<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory, UuidTrait;

    protected $table='product_size';

    public $incrementing = false;

    protected $keyType = 'uuid';
}
