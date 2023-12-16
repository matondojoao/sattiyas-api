<?php

namespace App\Repositories\Public;

class CartRepository
{
    public function getCart()
    {
        return session()->get('cart', []);
    }

    public function addToCart($productId, $quantity)
    {
        $products = $this->getCart();
        $productIds = array_column($products, 'product_id');

        if (in_array($productId, $productIds)) {
            $products = $this->productIncrement($productId, $quantity, $products);
        } else {
            $products[] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        session()->put('cart', $products);
    }

    public function removeFromCart($productId)
    {
        $products = $this->getCart();

        $products = array_filter($products, function ($line) use ($productId) {
            return $line['product_id'] != $productId;
        });

        session()->put('cart', $products);
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
