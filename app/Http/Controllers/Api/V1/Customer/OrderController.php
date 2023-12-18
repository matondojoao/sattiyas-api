<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\Customer\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $OrderRepository;

    public function __construct(OrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function placeOrder(OrderRequest $request)
    {
        $this->OrderRepository->placeOrder($request->validated());

        return response()->json(['message' => 'Order created successfully'], 200);
    }

    public function getUserOrders()
    {
        $userOrders = $this->OrderRepository->getUserOrders();

        return OrderResource::collection($userOrders);
    }
}
