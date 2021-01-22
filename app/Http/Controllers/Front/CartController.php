<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Integration\Stripe;
use App\Integration\PaypalV2;
use App\Models\ProductCoupon;
use App\Models\Module\EcommerceProduct;
use App\Models\Module\EcommerceCustomer;
use App\Models\Module\EcommerceOrder;
use App\Models\Module\EcommerceOrderItem;
use App\Models\Module\EcommercePayment;
use App\Models\StripeAccount;
use App\Models\PaypalAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart.index', [
            'modules' => tenant()->getBuilderModules()
        ]);
    }

    public function getData()
    {
        $cart = session('cart');
        $data['view'] = view('components.front.cartTable', compact('cart'))->render();
        $data['oneTotal'] = '$'.formatNumber($cart->onetimeTotalPrice ?? 0);
        $data['subTotal'] = '$'.formatNumber($cart->subTotalPrice ?? 0);
        $data['total'] = '$'.formatNumber($cart->totalPrice ?? 0);

        return response()->json(['status' => 1, 'data' => $data]);
    }

    public function remove(Request $request)
    {
        $oldCart = session('cart');
        $cart = new Cart($oldCart);
        $cart->removeOne($request->id);

        session()->put(['cart' => $cart]);

        return response()->json([
            'status' => 1,
            'data' => tenant()->getHeader(),
        ]);
    }

    public function empty()
    {
        session()->forget('cart');

        foreach (session()->all() as $key => $value) {
            if (strpos($key, 'paypal') === 0) {
                session()->forget($key);
            }
        }

        return response()->json([
            'status' => 1,
            'data' => tenant()->getHeader(),
        ]);
    }

    public function applyCoupon($coupon, $data)
    {
        $apply = false;
        if ($coupon->type == 'all') {
            $apply = true;
        } elseif ($coupon->type == 'category') {
            if (! empty($data['parameter']) && isset($data['parameter']['category_id']) && $data['parameter']['category_id'] == $coupon->model_id) {
                $apply = true;
            }
        } elseif ($coupon->type == 'subCategory') {
            if (! empty($data['parameter']) && isset($data['parameter']['subCategory_id']) && $data['parameter']['subCategory_id'] == $coupon->model_id) {
                $apply = true;
            }
        } elseif ($coupon->type == 'product') {
            if (! empty($data['item']) && $data['item']->id == $coupon->model_id) {
                $apply = true;
            }
        }

        if ($apply) {
            $data['price'] = formatNumber($data['price'] - ($data['price'] * ($coupon->discount / 100)));
            $data['discount'] = $coupon->discount;
            $coupon->withoutGlobalScopes()->where('id', $coupon->id)->where('reusable', 0)->update(['status' => '-1']);
        }

        return $data;
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'items' => 'required',
                'items.*' => 'required|integer|min:1',
            ], ['items.*.*' => 'Choose correct quantity', 'items.*' => 'Cart is empty!']);

            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $oldCart = session('cart');

            if ($request->has('coupon')) {
                $couponDetails = ProductCoupon::where('code', $request->get('coupon'))
                                ->active()
                                ->withoutGlobalScopes()
                                ->first();
                if ($couponDetails) {
                    if (count($oldCart->items) != 0) {
                        foreach ($oldCart->items as &$item) {
                            $item = $this->applyCoupon($couponDetails, $item);
                        }
                        unset($item);
                    }
                } else {
                    $failedAttempt = session()->exists('failedAttempt') ? (int) session('key') : 0;
                    session(['wrongCoupon' => ++$failedAttempt]);
                }
            }

            $cart = new Cart($oldCart);
            $cart->updateCart($request->items);

            session()->put(['cart' => $cart]);

            return response()->json([
                'status' => 1,
                'data' => tenant()->getHeader(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function checkout()
    {
        $cart = session('cart');
        if ($cart == null || $cart->totalQty == 0) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty1');
        }

        $gateway = tenant()->gateway();

        $modules = tenant()->getBuilderModules();

        return view('frontend.cart.checkout', compact('cart', 'gateway', 'modules'));
    }

    public function checkoutCart(Request $request) {
        $cart = session('cart');

        if ($cart == null || $cart->totalQty == 0) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty1');
        }

        $shipping = $request->shipping;
        $products = [];
        $productQnts = [];
        $total = 0;

        foreach ($cart->items as $key => $cartItem) {
            if (!isset($products[$cartItem['item']['id']])) {
                $products[$cartItem['item']['id']] = EcommerceProduct::with('standardPrice')
                    ->with('sizes')
                    ->with('variants')
                    ->with('colors')
                    ->with('prices')
                    ->findorfail($cartItem['item']['id']);
            }

            if (!isset($productQnts[$cartItem['item']['id']])) $productQnts[$cartItem['item']['id']] = 0;

            $price = $products[$cartItem['item']['id']]->prices;
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
            if (is_null($price)) $price = $products[$cartItem['item']['id']]->prices->first();

            $total += $price->price * $cartItem['quantity'];
            $productQnts[$cartItem['item']['id']] += $cartItem['quantity'];
            if (
                $price->price != $cartItem['price'] || 
                (!$products[$cartItem['item']['id']]->continue_selling && $productQnts[$cartItem['item']['id']] > $products[$cartItem['item']['id']]->quantity)) {
                return response()->json([
                    'success' => false
                ]);
            }
        }

        if ($total != $cart->totalPrice) {
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
                    'email'     =>  $shipping['email'],
                    'name'      =>  $shipping['first_name'] . ' ' . $shipping['last_name'],
                    'phone'     =>  $shipping['phone'],
                    'address'   =>  $shipping['address'].', '.$shipping['city'].', '.$shipping['state'].', '.$shipping['zip'],
                    'method'    =>  $paymentType,
                    'payment_account_id' =>  $accountId,
                    'default_source'    =>  'default_source'
                ]);
            }

            $order = EcommerceOrder::create([
                'web_id'            =>  tenant('id'),
                'user_id'           =>  user()->id,
                'customer_id'       =>  $customer->id,
                'shipping_address'  =>  json_encode($shipping),
                'status'            =>  'pending',
                'shipping_amount'   =>  0,
                'subtotal'          =>  $cart->subTotalPrice,
                'total'             =>  $cart->totalPrice,
                'payment_method'    =>  $paymentType
            ]);

            $products = [];
            foreach ($cart->items as $cartItem) {
                $total = 0;
                $subtotal = 0;
                if (!isset($products[$cartItem['item']['id']])) {
                    $products[$cartItem['item']['id']] = EcommerceProduct::with('standardPrice')
                        ->with('prices')
                        ->findorfail($cartItem['item']['id']);
                }

                EcommerceOrderItem::create([
                    'order_id'      =>  $order->id,
                    'product_id'    =>  $cartItem['item']['id'],
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
                foreach ($cart->items as $cartItem) {

                    $product = $cartItem['item'];
    
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
                    'success_url'   =>  $request->url() . '/success?method=stripe&session={CHECKOUT_SESSION_ID}',
                    'cancel_url'    =>  $request->url() . '/failed',
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
                foreach ($cart->items as $cartItem) {
                    $product = $cartItem['item'];
    
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
                    'url'   =>  $request->url(),
                    'total' =>  $cart->totalPrice
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
    }
}
