<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Integration\Stripe;
use App\Integration\PaypalV2;
use App\Models\Module\EcommerceProduct;
use App\Models\Module\EcommerceCustomer;
use App\Models\Module\EcommerceOrder;
use App\Models\Module\EcommerceOrderItem;
use App\Models\Module\EcommercePayment;
use App\Models\StripeAccount;
use App\Models\PaypalAccount;
use App\Models\User;

class EcommerceApi
{
    public function getEcommerceCategories() {
        return response()->json([
            'success' => true,
            'categories' => tenant()->getEcommerceCategories(),
        ]);
    }
    public function getEcommerceProducts() {
        return response()->json([
            'success' => true,
            'products' => tenant()->getEcommerceProducts(),
        ]);
    }

    public function getProduct(EcommerceProduct $product)
    {
        return response()->json([
            'product' => EcommerceProduct::with('standardPrice')
                ->with('sizes')
                ->with('variants')
                ->with('colors')
                ->with('prices')
                ->find($product->id),
         ]);
    }

    public function checkout(Request $request)
    {
        try {
            if (is_null(user())) {
                return response()->json([
                    'success' => false,
                    'action' => 'auth',
                ]);
            }

            $cart = $request->cart;

            $products = [];
            $productQnts = [];
            $total = 0;
            foreach ($cart['items'] as $key => $cartItem) {
                if (!isset($products[$cartItem['product']['id']])) {
                    $products[$cartItem['product']['id']] = EcommerceProduct::with('standardPrice')
                        ->with('sizes')
                        ->with('variants')
                        ->with('colors')
                        ->with('prices')
                        ->findorfail($cartItem['product']['id']);
                }

                if (!isset($productQnts[$cartItem['product']['id']])) $productQnts[$cartItem['product']['id']] = 0;

                $price = $products[$cartItem['product']['id']]->prices;
                if (isset($cartItem['size'])) {
                    $price = $price->where('size_id', $cartItem['size']['id']);
                }
                if (isset($cartItem['color'])) {
                    $price = $price->where('color_id', $cartItem['color']['id']);
                }
                if (isset($cartItem['variant'])) {
                    $price = $price->where('variant_id', $cartItem['variant']['id']);
                }
                $price = $price->first();
                if (is_null($price)) $price = $products[$cartItem['product']['id']]->prices->first();

                $total += $price->price * $cartItem['quantity'];
                $productQnts[$cartItem['product']['id']] += $cartItem['quantity'];
                if (
                    $price->price != $cartItem['price'] || 
                    (!$products[$cartItem['product']['id']]->continue_selling && $productQnts[$cartItem['product']['id']] > $products[$cartItem['product']['id']]->quantity)) {
                    return response()->json([
                        'success' => false
                    ]);
                }
            }

            if ($total != $cart['total']) {
                return response()->json([
                    'success' => false
                ]);
            }

            $paymentType = $request->type;
            $owner = tenant()->owner();

            // Validation if admin set payment method
            if ($paymentType == 'stripe') {
                $account = StripeAccount::where('web_id', tenant('id'))->where('user_id', $owner->id)->firstorfail();
                if (!($account->charges_enabled && $account->payouts_enabled && $account->details_submitted)) {
                    return response()->json([
                        'success' => false,
                    ]);
                }
            } else {
                $account = PaypalAccount::where('web_id', tenant('id'))->where('user_id', $owner->id)->firstorfail();
                if (!$account->payments_receivable || !$account->primary_email_confirmed || !$account->permission_granted) {
                    return response()->json([
                        'success' => false,
                    ]);
                }
            }

            $stripeClient = new Stripe();

            $customer = EcommerceCustomer::where('web_id', tenant('id'))->where('user_id', user()->id)->where('method', $paymentType)->first();
            try {
                DB::beginTransaction();
                
                if (is_null($customer)) {
                    $accountId = null;
                    if ($paymentType == 'stripe') {
                        $stripeCustomer = $stripeClient->stripe->customers->create([
                            'email' =>  user()->email,
                        ], [
                            'stripe_account'    =>  $account->stripe_id
                        ]);
                        $accountId = $stripeCustomer->id;
                    }

                    $customer = EcommerceCustomer::create([
                        'web_id'    =>  tenant('id'),
                        'user_id'   =>  user()->id,
                        'email'     =>  $cart['shippingAddress']['email'],
                        'name'      =>  $cart['shippingAddress']['first_name'] . ' ' . $cart['shippingAddress']['last_name'],
                        'phone'     =>  $cart['shippingAddress']['phone'],
                        'address'   =>  $cart['shippingAddress']['address'].', '.$cart['shippingAddress']['city'].', '.$cart['shippingAddress']['state'].', '.$cart['shippingAddress']['zip'],
                        'method'    =>  $paymentType,
                        'payment_account_id' =>  $accountId,
                        'default_source'    =>  'default_source'
                    ]);
                }

                $order = EcommerceOrder::create([
                    'web_id'            =>  tenant('id'),
                    'user_id'           =>  user()->id,
                    'customer_id'       =>  $customer->id,
                    'shipping_address'  =>  json_encode($cart['shippingAddress']),
                    'status'            =>  'pending',
                    'shipping_amount'   =>  0,
                    'subtotal'          =>  $cart['subtotal'],
                    'total'             =>  $cart['total'],
                    'payment_method'    =>  $paymentType
                ]);

                $products = [];
                foreach ($cart['items'] as $cartItem) {
                    $total = 0;
                    $subtotal = 0;
                    if (!isset($products[$cartItem['product']['id']])) {
                        $products[$cartItem['product']['id']] = EcommerceProduct::with('standardPrice')
                            ->with('prices')
                            ->findorfail($cartItem['product']['id']);
                    }

                    EcommerceOrderItem::create([
                        'order_id'      =>  $order->id,
                        'product_id'    =>  $cartItem['product']['id'],
                        'size_id'       =>  $cartItem['size']['id'] ?? null,
                        'color_id'      =>  $cartItem['color']['id'] ?? null,
                        'variant_id'    =>  $cartItem['variant']['id'] ?? null,
                        'quantity'      =>  $cartItem['quantity'],
                        'subtotal'      =>  (float) $cartItem['price'],
                        'total'         =>  (float) $cartItem['price'] * $cartItem['quantity'],
                        'web_id'        =>  tenant('id')
                    ]);
                }

                if ($paymentType == 'stripe') {
                    $cartItems = [];
                    foreach ($cart['items'] as $cartItem) {

                        $product = $cartItem['product'];
        
                        $priceData = [
                            'currency'      => 'usd',
                            'unit_amount'   =>  (int) $cartItem['price'] * 100, // Stripe requires the amount in cents
                            'product_data'  =>  [
                                'name'      =>  $product['title'],
                                'metadata'  =>  [
                                    'id'    =>  $product['id']
                                ]
                            ],
                        ];

                        $cartItems[] = [
                            'price_data'  =>  $priceData,
                            'quantity'    =>  $cartItem['quantity']
                        ];
                    }
        
                    $session = $stripeClient->stripe->checkout->sessions->create([
                        'success_url'   =>  $request->url . '/success?method=stripe&session={CHECKOUT_SESSION_ID}',
                        'cancel_url'    =>  $request->url . '/failed',
                        'line_items'    =>  $cartItems,
                        'payment_intent_data'   =>  [
                            // 'application_fee_amount'    => 2, // Bizinabox fee 
                            'transfer_data' =>  [
                                'destination'   =>  $account->stripe_id
                            ]
                        ],
                        'mode'          =>  'payment',
                        'metadata'      =>  [
                            'order' =>  $order->id,
                            'mode'  =>  'ecommerce'
                        ]
                    ]);
                    $actionUrl = $session->url;
                    $payment_id = $session->id;
                } else {
                    $items = [];
                    foreach ($cart['items'] as $cartItem) {
                        $product = $cartItem['product'];
        
                        $items[] = [
                            'name'  =>  $product['title'],
                            'quantity'    =>  $cartItem['quantity'],
                            'unit_amount'  =>  [
                                'currency_code' =>  'USD',
                                'value' =>  (float) $cartItem['price']
                            ],
                        ];
                    }
    
                    $orderData = [
                        'order_id'    =>  $order->id,
                        'payee_merchant_id' =>  $account->merchant_paypal_id,
                        'items' =>  $items,
                        'url'   =>  $request->url,
                        'total' =>  $cart['total']
                    ];
    
                    $paypal = new PaypalV2();
                    $session = $paypal->createOrder($orderData);
                    if ($session['status'] !== 'PAYER_ACTION_REQUIRED') {
                        return response()->json([
                            'success' => false,
                        ]);
                    }
    
                    $actionUrl = $session['links'][1]['href'];
                    $payment_id = $session['id'];
                }
    
                $order->payment_id = $payment_id;
                $order->save();

                DB::commit();
            } catch (\Exception $e) {
                \Log::info('EcommerceApi checkout create order failed');
                \Log::info(json_encode($e->getMessage()));
                return response()->json([
                    'success' => false,
                ]);
            }

            return response()->json([
                'success' => true,
                'url' => $actionUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [json_encode($e->getMessage())],
            ]);
        }
    }

    // @deprecated: handle logic without webhook
    public function checkoutSuccess(Request $request)
    {
        try {
            // @TODO: auth check #code

            $sessionId = $request->session;
            $cart = $request->cart;

            $stripeClient = new Stripe();

            $session = $stripeClient->stripe->checkout->sessions->retrieve($sessionId);
            // Check if stripe session is already performed, prevent multiple storing with one session.
            $currentPayment = EcommercePayment::where('charge_id', $session->payment_intent)->first();
            if (!is_null($currentPayment)) {
                return response()->json([
                    'success'   =>  false,
                ]);
            }

            foreach ($cart['items'] as $cartItem) {
                $product = $cartItem['product'];
                if ($session->metadata[$product['id']] != $cartItem['quantity']) {
                    return response()->json([
                        'success'   =>  false,
                    ]);
                };
            }

            if (is_null($session) || $session->status !== 'complete') {
                return response()->json([
                    'success'   =>  false
                ]);
            }

            $paymentIntent = $stripeClient->stripe->paymentIntents->retrieve($session->payment_intent, []);
            if (is_null($paymentIntent) || $paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'success'   =>  false
                ]);
            }

            DB::beginTransaction();

            try {
                // need to consider this logic again, do not recreate user #code
                $stripeCustomer = $stripeClient->stripe->customers->create([
                    'email' =>  user()->email,
                ]);
                $customer = EcommerceCustomer::create([
                    'web_id'    =>  $cart['webId'],
                    'email'     =>  $cart['shippingAddress']['email'],
                    'name'      =>  $cart['shippingAddress']['first_name'] . ' ' . $cart['shippingAddress']['last_name'],
                    'phone'     =>  $cart['shippingAddress']['phone'],
                    'address'   =>  $cart['shippingAddress']['address'].', '.$cart['shippingAddress']['city'].', '.$cart['shippingAddress']['state'].', '.$cart['shippingAddress']['zip'],
                    'method'    =>  'stripe',
                    'payment_account_id' =>  $stripeCustomer->id,
                    'default_source'    =>  'default_source'
                ]);
                $order = EcommerceOrder::create([
                    'web_id'            =>  $cart['webId'],
                    'user_id'           =>  user()->id,
                    'customer_id'       =>  $customer->id,
                    'shipping_address'  =>  json_encode($cart['shippingAddress']),
                    'status'            =>  'success',
                    'shipping_amount'   =>  0,
                    'subtotal'          =>  $cart['subtotal'],
                    'total'             =>  $cart['total'],
                    'tracking_code'     =>  $paymentIntent->payment_method
                ]);
                foreach ($cart['items'] as $cartItem) {
                    EcommerceOrderItem::create([
                        'order_id'      =>  $order->id,
                        'product_id'    =>  $cartItem['product']['id'],
                        'quantity'      =>  $cartItem['quantity'],
                        'subtotal'      =>  (float) $cartItem['price'],
                        'total'         =>  (float) $cartItem['price'] * $cartItem['quantity'],
                        'web_id'        =>  $cart['webId']
                    ]);
                }
                EcommercePayment::create([
                    'web_id'            =>  $cart['webId'],
                    'order_id'          =>  $order->id,
                    'user_id'           =>  user()->id,
                    'customer_id'       =>  $customer->id,
                    'charge_id'         =>  $paymentIntent->id,
                    'payment_status'    =>  $paymentIntent->status,
                    'amount'            =>  $paymentIntent->amount / 100,
                    'fees'              =>  0
                ]);

                DB::commit();

                return response()->json([
                    'success'   =>  true,
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                \Log::info('EcommerceApi checkoutSuccess DB commit failed');
                \Log::info(json_encode($e->getMessage()));
                return response()->json([
                    'success'   =>  false,
                ]);
            }

        } catch (\Exception $e) {
            \Log::info('EcommerceApi checkoutSuccess function failed');
            \Log::info(json_encode($e->getMessage()));
            return response()->json([
                'success' => true,
            ]);
        }
    }
}
