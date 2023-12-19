<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryOptionResource;
use App\Repositories\Public\DeliveryOptionRepository;

class DeliveryOptionController extends Controller
{
    protected $deliveryOptionRepository;

    public function __construct(DeliveryOptionRepository $deliveryOptionRepository)
    {
        $this->deliveryOptionRepository = $deliveryOptionRepository;
    }

    public function index()
    {
        $deliveryOptions = $this->deliveryOptionRepository->getAllDeliveryOptions();

        return DeliveryOptionResource::collection($deliveryOptions);
    }
}
