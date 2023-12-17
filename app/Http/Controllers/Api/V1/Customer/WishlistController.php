<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
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

    public function addToWishlist(Request $request)
    {
        $user = $request->user();
        $this->wishlistRepository->addToWishlist($request->all());

        return response()->json(['message' => 'Product added to wishlist successfully']);
    }

    public function removeFromWishlist($productId)
    {
        $this->wishlistRepository->removeFromWishlist($productId);

        return response()->json(['message' => 'Product removed from wishlist successfully']);
    }

    public function getWishlist()
    {
        $wishlists = $this->wishlistRepository->getWishlist();

        return WishlistResource::collection($wishlists);
    }
}
