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

    public function placeOrder($data)
    {
        try {
            $cartItems = $data['cartItems'];
            $orderDetails = $data['orderDet'];
            $stripeToken = '';
            $couponCode = '';

            $cartItems = json_decode(json_encode($cartItems), true);
            $orderDetails = json_decode(json_encode($orderDetails), true);

            // if (isset($orderDetails['_value'])) {
            //     $orderDetails = $orderDetails['_value'];
            //     if (isset($orderDetails['stripeToken'])) {
            //         $stripeToken = $orderDetails['stripeToken'];
            //          $couponCode = $orderDetails['couponCode'];
            //     }
            // }
            $userEmail = $this->getAuthUser()->email;

            $defaultValues = [
                'delivery_option_id' => '8dd7be5e-307e-4cbd-9a20-bf47beedf33e',
                'payment_status' => 'processing',
                'fulfillment_status' => 'pending',
            ];

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customerDetails = [
                'name' => $orderDetails['name'],
                'address' => $orderDetails['address'],
                'city' => $orderDetails['city'],
                'state' => $orderDetails['state'],
                'postal_code' => $orderDetails['postal_code'],
                'country_region' => $orderDetails['country_region'],
                'phone' => $orderDetails['phone'],
            ];

            $stripeCustomerId = $this->getStripeCustomerId($userEmail, $stripeToken, $customerDetails);

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

            $totalDiscount = 0;


            if ($couponCode) {
                $couponData = \App\Models\Promotion::where('code', $couponCode)->first();

                if ($couponData->type == 'amount') {
                    $totalDiscount = $couponData->value;
                } elseif ($couponData->type == 'percentage') {
                    $totalDiscount -= ($totalDiscount * ($couponData->value / 100));
                }

                $couponData->increment('usage_count', 1);

                $order->update(['discount' => $totalDiscount]);
            }
            if ($order->deliveryOption) {
                $total += $order->deliveryOption->price - $totalDiscount;
            }

            $paymentIntent = Stripe\PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'BRL',
                'customer' => $stripeCustomerId,
                'description' => implode(', ', $itemDescriptions),
                'payment_method_types' => ['card'],
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            $pdf = PDF::loadView('order.invoice', ['order' => $order]);

            if (!file_exists(storage_path('app/public/orders'))) {
                mkdir(storage_path('app/public/orders'), 0755, true);
            }

            $pdfPath = storage_path('app/public/orders/order_' . $order->id . '.pdf');
            $pdf->save($pdfPath);

            $order->user->notify(new OrderPlacedNotification($pdfPath, $order));

            $order->update(['payment_status' => $paymentIntent->status]);

            return response()->json(['order_id' => $order->id], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Error saving the order to the database.', 'details' => $e->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Unknown error while saving the order.', 'details' => $th->getMessage() , 'trace' => $th->getTrace()], 500);
        }
    }

    public function getStripeCustomerId($userEmail, $token, $customerDetails)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $stripeCustomerId = $this->getAuthUser()->stripe_customer_id;

            if (!$stripeCustomerId) {
                $customerParams = [
                    'email' => $userEmail,
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

                if ($this->getAuthUser()->stripe_customer_id) {
                    $customerParams['id'] = $this->getAuthUser()->stripe_customer_id;
                }

                $stripeCustomer = Stripe\Customer::create($customerParams);

                $stripeCustomerId = $stripeCustomer->id;

                $this->getAuthUser()->update(['stripe_customer_id' => $stripeCustomerId]);
            }

            return $stripeCustomerId;
        } catch (\Exception $e) {
            return response()->json('Erro ao criar/atualizar cliente no Stripe: ' . $e->getMessage());
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
