<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Public\CartRepository;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index()
    {
        if (Session::has('cart')) {
            $cartItems = Session::get('cart');
            $cartDetails = [];

            foreach ($cartItems as $cartItem) {
                if (is_array($cartItem)) {
                    $product = Product::find($cartItem['product_id']);

                    if ($product) {
                        $firstImage = $product->images()->first();
                        $total = 0;
                        $price = 0;

                        if ($product->sale_price) {
                            $price = $product->sale_price;
                            $total = $product->sale_price * $cartItem['quantity'];
                        } else {
                            $price = $product->regular_price;
                            $total = $product->regular_price * $cartItem['quantity'];
                        }

                        $cartDetails[] = [
                            'product_id' => $cartItem['product_id'],
                            'product_name' => $product->name,
                            'quantity' => $cartItem['quantity'],
                            'price' => $price,
                            'total' => $total,
                            'first_image' => $firstImage ? url('storage/' . $firstImage->image_path) : null,
                        ];
                    }
                }
            }

            return response()->json(['cart' => $cartDetails]);
        } else {
            return response()->json(['cart' => []]);
        }
    }


    public function add(CartRequest $request)
    {
        $product = Product::find($request->product);

        if (!$product || $request->quantity == 0) {
            return response()->json(['error' => 'Product not found or invalid quantity'], 404);
        }

        $productQuantity = $product->stock->quantity;
        $cartQuantity = $this->cartRepository->getQuantityInCart($request->product);

        if (($request->quantity + $cartQuantity) > $productQuantity) {
            return response()->json(['error' => 'Requested quantity exceeds available stock'], 400);
        }

        $this->cartRepository->addToCart($product->id, $request->quantity);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function remove($productId)
    {
        $this->cartRepository->removeFromCart($productId);
        return response()->json(['message' => 'Product removed from cart successfully']);
    }
}
