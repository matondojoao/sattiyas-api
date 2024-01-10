<?php

namespace App\Repositories\Customer;

use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use App\Repositories\Traits\TraitRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Stripe;

class OrderRepository
{
    use TraitRepository;

    public function place($data)
    {
        try {

            $cartItems = $data['cartItems'];

            $order = $this->getAuthUser()->orders()->create([
                'delivery_option_id' => '8dd7be5e-307e-4cbd-9a20-bf47beedf33e',
                'payment_status' => 'pending',
                'fulfillment_status' => 'pending',
            ]);

            $cartDetails = [];

            foreach ($cartItems as $cartItem) {
                $cartDetails[] = [
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                ];
            }

            $order->orderItems()->createMany($cartDetails);

            return response()->json(['order_id' => $order->id], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Erro ao salvar o pedido no banco de dados.', 'details' => $e->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro desconhecido ao salvar o pedido.', 'details' => $th->getMessage()], 500);
        }
    }
    public function placeOrder(array $data)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customerEmail = $this->getAuthUser()->email;
            $token = $data['stripeToken'];

            $stripeCustomerId = $this->getStripeCustomerId($customerEmail, $token);

            $cartItems = session()->get('cart', []);
            $itemDescriptions = [];

            $order = $this->getAuthUser()->orders()->create([
                'delivery_option_id' => $data['delivery_option_id'],
                'payment_status' => 'pending',
                'fulfillment_status' => 'pending',
                'payment_method_id' => $data['payment_method_id'],
            ]);

            $totalDiscount = 0;

            if (session()->get('coupon')) {
                $coupon = session()->get('coupon');

                if ($order->deliveryOption) {
                    $totalDiscount += $order->deliveryOption->price;
                }

                if ($coupon['type'] == 'amount') {
                    $totalDiscount = $coupon['value'];
                } elseif ($coupon['type'] == 'percentage') {
                    $totalDiscount -= ($totalDiscount * ($coupon['value'] / 100));
                }

                $couponData = \App\Models\Promotion::where('code', $coupon['code'])->first();

                if ($couponData) {
                    $couponData->increment('usage_count', 1);
                }

                $order->discount = $totalDiscount;
                $order->save();
            }

            $cartDetails = [];

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                $product->stock()->decrement('quantity', $cartItem['quantity']);

                if ($product) {

                    $price = 0;
                    if ($product->sale_price) {
                        $price = $product->sale_price * $cartItem['quantity'];
                    } else {
                        $price = $product->regular_price * $cartItem['quantity'];
                    }

                    $cartDetails[] = [
                        'product_id' => $cartItem['product_id'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $price,
                    ];
                    $itemDescriptions[] = "{$product->name} ({$cartItem['quantity']}x)";
                }
            }

            $order->orderItems()->createMany($cartDetails);

            $total = 0;

            foreach ($order->orderItems as $item) {
                $total += $item->price * $item->quantity;
            }

            if ($order->deliveryOption) {
                $total += $order->deliveryOption->price;
            }

            if (session()->has('coupon')) {
                $coupon = session('coupon');

                if ($coupon['type'] == 'amount') {
                    $total -= $coupon['value'];
                } elseif ($coupon['type'] == 'percentage') {
                    $total -= ($total * ($coupon['value'] / 100));
                }
            }

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'brl',
                'customer' => $stripeCustomerId,
                'description' => implode(', ', $itemDescriptions),
            ]);

            $pdf = PDF::loadView('order.invoice', ['order' => $order]);

            $pdfPath = storage_path('app/public/orders/order_' . $order->id . '.pdf');
            $pdf->save($pdfPath);

            $order->user->notify(new OrderPlacedNotification($pdfPath, $order));

            session()->forget('cart', []);

            session()->forget('coupon');

            return response()->json(['client_secret' => $paymentIntent->client_secret], 200);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['message' => 'Card error. Please check your card details and try again.'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred. Please try again later.' . $e], 500);
        }
    }

    public function getStripeCustomerId($userEmail, $token)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripeCustomerId = $this->getAuthUser()->stripe_customer_id;

        if (!$stripeCustomerId) {
            $stripeCustomer = Stripe\Customer::create([
                'email' => $userEmail,
                'source' => $token,
            ]);

            $stripeCustomerId = $stripeCustomer->id;

            $this->getAuthUser()->update(['stripe_customer_id' => $stripeCustomerId]);
        }

        return $stripeCustomerId;
    }

    public function find(string $id)
    {
        return $this->getAuthUser()->orders()->findOrFail($id);
    }

    public function getUserOrders()
    {
        return $this->getAuthUser()->orders()->with('orderItems.product.images','deliveryOption')->orderBy('created_at', 'desc')->paginate(10);
    }
}
