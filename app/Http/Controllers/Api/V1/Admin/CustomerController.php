<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Repositories\Admin\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $orderRepository;

    public function __construct(CustomerRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function index(Request $request)
    {
        return CustomerResource::collection($this->orderRepository->getAllCustomers());
    }

    public function getCustomersReport(Request $request)
    {
        $data=$request->only('date','start_date','end_date');
        return $this->orderRepository->getCustomersReport($data);
    }

    public function destroy($id)
    {
        return $this->orderRepository->delete($id);
    }
}
