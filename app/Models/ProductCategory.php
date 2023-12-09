<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, UuidTrait;

    protected $table='product_category';

    public $incrementing = false;

    protected $keyType = 'uuid';
}
