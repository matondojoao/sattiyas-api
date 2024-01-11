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
            $orderDetails = $data['orderDet'];
            $stripeToken = '';

            $cartItems = json_decode(json_encode($cartItems), true);
            $orderDetails = json_decode(json_encode($orderDetails), true);

            if (isset($orderDetails['_value'])) {
                $orderDetails = $orderDetails['_value'];
                if (isset($orderDetails['stripeToken'])) {
                    $stripeToken = $orderDetails['stripeToken'];
                }
            }

            $defaultValues = [
                'delivery_option_id' => '8dd7be5e-307e-4cbd-9a20-bf47beedf33e',
                'payment_status' => 'pending',
                'fulfillment_status' => 'pending',
            ];

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customerDetails = [
                'name' => $orderDetails['name'],
                'email_address' => $orderDetails['email_address'],
                'address' => $orderDetails['address'],
                'city' => $orderDetails['city'],
                'state' => $orderDetails['state'],
                'postal_code' => $orderDetails['postal_code'],
                'country_region' => $orderDetails['country_region'],
                'phone' => $orderDetails['phone'],
            ];

            $stripeCustomerId = $this->generateStripeCustomerId($stripeToken, $customerDetails);

            $orderData = array_merge($defaultValues, $orderDetails);

            $order = $this->getAuthUser()->orders()->create($orderData);

            $cartDetails = [];
            $itemDescriptions = [];

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $product->stock()->decrement('quantity', $cartItem['quantity']);

                $price = $product->sale_price ? $product->sale_price * $cartItem['quantity'] : $product->regular_price * $cartItem['quantity'];

                $cartDetails[] = [
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $price,
                ];

                $itemDescriptions[] = "{$product->name} ({$cartItem['quantity']}x)";
            }

            $order->orderItems()->createMany($cartDetails);

            $total = collect($order->orderItems)->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            if ($order->deliveryOption) {
                $total += $order->deliveryOption->price;
            }

            $paymentIntent = Stripe\PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'BRL',
                'customer' => $stripeCustomerId,
                'description' => implode(', ', $itemDescriptions),
                'payment_method_types' => ['card'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $stripeToken,
                    ],
                ],
            ]);

            $pdf = PDF::loadView('order.invoice', ['order' => $order]);

            if (!file_exists(storage_path('app/public/orders'))) {
                mkdir(storage_path('app/public/orders'), 0755, true);
            }

            $pdfPath = storage_path('app/public/orders/order_' . $order->id . '.pdf');
            $pdf->save($pdfPath);

            $order->user->notify(new OrderPlacedNotification($pdfPath, $order));

            return response()->json(['order_id' => $order->id], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Erro ao salvar o pedido no banco de dados.', 'details' => $e->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro desconhecido ao salvar o pedido.', 'details' => $th->getMessage()], 500);
        }
    }
    // public function placeOrder(array $data)
    // {
    //     try {
    //         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //         $customerEmail = $this->getAuthUser()->email;
    //         $token = $data['stripeToken'];

    //         $stripeCustomerId = $this->getStripeCustomerId($customerEmail, $token);

    //         $cartItems = session()->get('cart', []);
    //         $itemDescriptions = [];

    //         $order = $this->getAuthUser()->orders()->create([
    //             'delivery_option_id' => $data['delivery_option_id'],
    //             'payment_status' => 'pending',
    //             'fulfillment_status' => 'pending',
    //             'payment_method_id' => $data['payment_method_id'],
    //         ]);

    //         $totalDiscount = 0;

    //         if (session()->get('coupon')) {
    //             $coupon = session()->get('coupon');

    //             if ($order->deliveryOption) {
    //                 $totalDiscount += $order->deliveryOption->price;
    //             }

    //             if ($coupon['type'] == 'amount') {
    //                 $totalDiscount = $coupon['value'];
    //             } elseif ($coupon['type'] == 'percentage') {
    //                 $totalDiscount -= ($totalDiscount * ($coupon['value'] / 100));
    //             }

    //             $couponData = \App\Models\Promotion::where('code', $coupon['code'])->first();

    //             if ($couponData) {
    //                 $couponData->increment('usage_count', 1);
    //             }

    //             $order->discount = $totalDiscount;
    //             $order->save();
    //         }

    //         $cartDetails = [];

    //         foreach ($cartItems as $cartItem) {
    //             $product = Product::find($cartItem['product_id']);

    //             $product->stock()->decrement('quantity', $cartItem['quantity']);

    //             if ($product) {

    //                 $price = 0;
    //                 if ($product->sale_price) {
    //                     $price = $product->sale_price * $cartItem['quantity'];
    //                 } else {
    //                     $price = $product->regular_price * $cartItem['quantity'];
    //                 }

    //                 $cartDetails[] = [
    //                     'product_id' => $cartItem['product_id'],
    //                     'quantity' => $cartItem['quantity'],
    //                     'price' => $price,
    //                 ];
    //                 $itemDescriptions[] = "{$product->name} ({$cartItem['quantity']}x)";
    //             }
    //         }

    //         $order->orderItems()->createMany($cartDetails);

    //         $total = 0;

    //         foreach ($order->orderItems as $item) {
    //             $total += $item->price * $item->quantity;
    //         }

    //         if ($order->deliveryOption) {
    //             $total += $order->deliveryOption->price;
    //         }

    //         if (session()->has('coupon')) {
    //             $coupon = session('coupon');

    //             if ($coupon['type'] == 'amount') {
    //                 $total -= $coupon['value'];
    //             } elseif ($coupon['type'] == 'percentage') {
    //                 $total -= ($total * ($coupon['value'] / 100));
    //             }
    //         }

    //         $method = \Stripe\PaymentMethod::create([
    //             'type' => 'card'
    //         ]);

    //         $paymentIntent = \Stripe\PaymentIntent::create([
    //             'payment_method_types' => ['card'],
    //             'payment_method' => $method->id,
    //             'amount' => $total * 100,
    //             'currency' => 'BRL',
    //             'customer' => $stripeCustomerId,
    //             'description' => implode(', ', $itemDescriptions),
    //         ]);

    //         $paymentIntentId = $paymentIntent->id;

    //         $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

    //         $paymentIntent->confirm();

    //         $pdf = PDF::loadView('order.invoice', ['order' => $order]);

    //         $pdfPath = storage_path('app/public/orders/order_' . $order->id . '.pdf');
    //         $pdf->save($pdfPath);

    //         $order->user->notify(new OrderPlacedNotification($pdfPath, $order));

    //         session()->forget('cart', []);

    //         session()->forget('coupon');

    //         return response()->json(['client_secret' => $paymentIntent->client_secret], 200);
    //     } catch (\Stripe\Exception\CardException $e) {
    //         return response()->json(['message' => 'Card error. Please check your card details and try again.'], 400);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'An unexpected error occurred. Please try again later.' . $e], 500);
    //     }
    // }

    public function generateStripeCustomerId($token, $customerDetails)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customerParams = [
                'email' => $customerDetails['email_address'],
                'source' => $token,
                'name' => $customerDetails['name'],
                'address' => [
                    'line1' => $customerDetails['address'],
                    'city' => $customerDetails['city'],
                    'state' => $customerDetails['state'],
                    'postal_code' => $customerDetails['postal_code'],
                    'country' => $customerDetails['country_region'],
                ],
                'phone' => $customerDetails['phone'],
            ];

            $stripeCustomer = Stripe\Customer::create($customerParams);

            return $stripeCustomer->id;
        } catch (\Exception $e) {
            return response()->json('Erro ao criar cliente no Stripe: ' . $e->getMessage());
            throw $e;
        }
    }

    public function find(string $id)
    {
        return $this->getAuthUser()->orders()->with('orderItems.product', 'deliveryOption')->findOrFail($id);
    }

    public function getUserOrders()
    {
        return $this->getAuthUser()->orders()->with('orderItems.product', 'deliveryOption')->orderBy('created_at', 'desc')->paginate(10);
    }
}
