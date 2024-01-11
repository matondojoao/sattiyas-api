<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
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

    public function placeOrder(Request $request)
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

        return $this->OrderRepository->placeOrder($data);
    }

    public function getUserOrders()
    {
        $userOrders = $this->OrderRepository->getUserOrders();

        return OrderResource::collection($userOrders);
    }
}
