<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $data=$request->only('payment_status','fulfillment_status');
        return OrderResource::collection($this->orderRepository->all($data));
    }

    public function getSalesReport(Request $request)
    {
        $data=$request->only('date','start_date','end_date');
        return $this->orderRepository->getSalesReport($data);
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
