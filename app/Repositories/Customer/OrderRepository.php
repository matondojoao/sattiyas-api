<?php

namespace App\Repositories\Customer;

use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use App\Repositories\Traits\TraitRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderRepository
{
    use TraitRepository;

    public function placeOrder(array $data)
    {
        $cartItems = session()->get('cart', []);

        $order = $this->getAuthUser()->orders()->create([
            'delivery_option_id' => $data['delivery_option_id'],
            'payment_status' => 'pending',
            'fulfillment_status' => 'pending',
            'payment_method_id' => $data['payment_method_id'],
        ]);

        $cartDetails = [];

        foreach ($cartItems as $cartItem) {
            $cartDetails = [];

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem['product_id']);
                if ($product) {
                    $cartDetails[] = [
                        'product_id' => $cartItem['product_id'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $product->sale_price ? $product->sale_price : $product->regular_price,
                    ];
                }
            }
        }
        $order->orderItems()->createMany($cartDetails);
        $pdf = PDF::loadView('order.invoice', ['order' => $order]);

        $pdfPath = storage_path('app/public/order_' . $order->id . '.pdf');
        $pdf->save($pdfPath);

        $order->user->notify(new OrderPlacedNotification($pdfPath, $order));
    }

    public function getUserOrders()
    {
        return $this->getAuthUser()->orders()->with('orderItems.product.images','paymentMethod','deliveryOption')->orderBy('created_at', 'desc')->paginate(10);
    }
}
