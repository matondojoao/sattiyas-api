<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetStockResource;
use App\Repositories\Admin\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $StockRepository;

    public function __construct(StockRepository $StockRepository)
    {
        $this->StockRepository = $StockRepository;
    }

    public function index(Request $request)
    {
        $data=$request->only('status');
        return  GetStockResource::collection($this->StockRepository->getStocks($data));
    }
}
