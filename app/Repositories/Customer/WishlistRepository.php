<?php

namespace App\Repositories\Customer;

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
        // ... código existente ...
    }

    public function getWishlist()
    {
        $user = $this->getAuthUser();

        if ($user) {
            $wishlists = $user->wishlists;

            if ($wishlists->isNotEmpty()) {
                $wishlists->load('products');
            }
        }

        return $wishlists;
    }
}
