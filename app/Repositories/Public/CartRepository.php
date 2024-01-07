<?php

namespace App\Repositories\Public;

use Illuminate\Support\Facades\Session;

class CartRepository
{
    public function getCart()
    {
        return Session::get('cart');

    }

    public function addToCart($productId, $quantity)
    {
        $products = $this->getCart();

        $existingProduct = collect($products)->firstWhere('product_id', $productId);

        if ($existingProduct) {
            $existingProduct['quantity'] += $quantity;
        } else {
            $products[] = ['product_id' => $productId, 'quantity' => $quantity];
        }
        Session::flush();

        Session::put('cart', $products);
    }

    public function getQuantityInCart($productId)
    {
        $cart = $this->getCart();

        $item = collect($cart)->firstWhere('product_id', $productId);

        return $item ? $item['quantity'] : 0;
    }

    public function removeFromCart($productId)
    {
        $products = collect($this->getCart())->reject(function ($line) use ($productId) {
            return $line['product_id'] == $productId;
        })->values()->all();

        Session::put('cart', $products);
    }

    private function productIncrement($productId, $quantity, $products)
    {
        return array_map(function ($line) use ($productId, $quantity) {
            if ($productId == $line['product_id']) {
                $line['quantity'] += $quantity;
            }
            return $line;
        }, $products);
    }
}
