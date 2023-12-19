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
        $cartItems = session()->get('cart', []);

        if (count($cartItems) > 0) {
            return $this->OrderRepository->placeOrder($request->validated());
        } else {
            return response()->json(['message' => 'Cart is empty. Order not created.'], 400);
        }
    }

    public function getUserOrders()
    {
        $userOrders = $this->OrderRepository->getUserOrders();

        return OrderResource::collection($userOrders);
    }
}
