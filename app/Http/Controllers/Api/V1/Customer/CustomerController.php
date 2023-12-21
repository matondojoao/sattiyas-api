<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Customer\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $CustomerRepository;

    public function __construct(CustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function profile()
    {
        return new UserResource($this->CustomerRepository->getCustomerInfo());
    }

    public function update(Request $request)
    {
        return new UserResource($this->CustomerRepository->update($request->all()));
    }
}
