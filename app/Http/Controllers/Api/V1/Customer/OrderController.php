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

    public function show($id)
    {
        $order = $this->OrderRepository->find($id);

        return new OrderResource($order);
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

    public function place(Request $request)
{
    $requestData = json_decode($request->getContent(), true);

    if ($requestData === null || !isset($requestData['cartItems']) || !isset($requestData['orderDet'])) {
        return response()->json(['error' => 'Invalid request data.'], 400);
    }

    $cartItems = $requestData['cartItems'];
    $orderDet = $requestData['orderDet'];

    $data = [
        'cartItems' => $cartItems,
        'orderDet' => $orderDet,
    ];
    return response()->json(['orderDet' => $orderDet]);
    // return $this->OrderRepository->place($data);
}

    public function getUserOrders()
    {
        $userOrders = $this->OrderRepository->getUserOrders();

        return OrderResource::collection($userOrders);
    }
}
