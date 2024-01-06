<?php

namespace App\Repositories\Customer;

use App\Models\Wishlist;
use App\Repositories\Traits\TraitRepository;

class WishlistRepository
{
    use TraitRepository;

    public function addToWishlist(array $data)
    {
        return $this->getAuthUser()->wishlists()->create($data);
    }

    public function removeFromWishlist($productId)
    {
        $user = $this->getAuthUser();

        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['message' => 'Item removed from the wishlist successfully.']);
        } else {
            return response()->json(['message' => 'Item not found in the wishlist.'], 404);
        }
    }

    public function getWishlist()
    {
        $user = $this->getAuthUser();

        if ($user) {
            $wishlists = $user->wishlists;

            if ($wishlists->isNotEmpty()) {
                $wishlists->load('product.stock',);
            }
        }

        return $wishlists;
    }
}
