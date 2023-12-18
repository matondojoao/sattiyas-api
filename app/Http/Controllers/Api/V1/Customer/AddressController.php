<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\BillingAddressResource;
use App\Repositories\Customer\AddressRepository;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function createOrUpdatebillingAddress(AddressRequest $request)
    {

        $data = $request->all();
        $address = $this->addressRepository->createOrUpdatebillingAddress($data);
        return new BillingAddressResource($address);
    }
}
