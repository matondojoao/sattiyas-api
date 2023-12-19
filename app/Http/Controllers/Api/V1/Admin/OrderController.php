<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\Admin\OrderRepository;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        return new OrderResource($order);
    }
    public function update(UpdateOrderRequest $request, $id)
    {
        $data = $request->validated();
        $order = $this->orderRepository->update($id, $data);

        return new OrderResource($order);
    }

    public function destroy($id)
    {
        return $this->orderRepository->delete($id);
    }
}
