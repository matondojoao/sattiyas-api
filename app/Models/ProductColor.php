<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory, UuidTrait;

    protected $table='product_color';

    public $incrementing = false;

    protected $keyType = 'uuid';
}
