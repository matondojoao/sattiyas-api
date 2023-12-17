<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Repositories\Customer\WishlistRepository;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function addToWishlist(WishlistRequest $request)
    {
        $user = $request->user();
        $this->wishlistRepository->addToWishlist($request->all());

        return response()->json(['message' => 'Product added to wishlist successfully']);
    }

    public function removeFromWishlist($productId)
    {
        return $this->wishlistRepository->removeFromWishlist($productId);
    }

    public function getWishlist()
    {
        $wishlists = $this->wishlistRepository->getWishlist();

        return WishlistResource::collection($wishlists);
    }
}
