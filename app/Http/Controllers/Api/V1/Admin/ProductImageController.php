<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ProductImageRespoitory;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    protected $ProductImageRespoitory;

    public function __construct(ProductImageRespoitory $ProductImageRespoitory)
    {
        $this->ProductImageRespoitory = $ProductImageRespoitory;
    }

    public function destroy($id)
    {
        return $this->ProductImageRespoitory->deleteImageById($id);
    }
}
