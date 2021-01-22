<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Integration\Paypal;
use App\Integration\Stripe;
use App\Models\BlogAdsListing;
use App\Models\DirectoryAdsListing;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteAdsListing;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBlogPackage;
use App\Models\UserDirectoryPackage;
use App\Models\UserEcommerceProduct;
use App\Models\UserProduct;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    public function login()
    {
        session()->put(['url.intended' => request('redirect')]);

        return redirect()->route('login');
    }

    public function stripeExecute(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'email' => 'required|email|max:191',
                'address' => 'required|max:191',
                'country' => 'required|max:191',
                'city' => 'required|max:191',
                'state' => 'required|max:191',
                'zipcode' => 'required|max:191',
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => 2, 'data' => $validation->errors()]);
            }

            $cart = session('cart');
            $guestEmail = $request->email;

            if (Auth::check() == false && $request->has('guest_email')) {
                $guestEmail = $request->get('guest_email');
            }

            $stripeClient = new Stripe();

            $recurrent_products = collect($cart->items)->where('recurrent', 1)->reverse()->toArray();
            $onetime_products = collect($cart->items)->where('recurrent', 0)->reverse()->toArray();

            $usermodel = new User();
            $getuserinfo = $usermodel->getPurchaseUser($guestEmail);
            $authuser = $getuserinfo['user'];
            $new = $getuserinfo['new'];

            $customer = $stripeClient->stripe->customers->create([
                'email' => $request->email,
                'source' => $request->token,
                'name' => $request->name,
                'address' => [
                    'line1' => $request->address,
                    'postal_code' => $request->zipcode,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                ],
            ]);

            $new_order = new Order();
            $order = $new_order->saveItem($cart, $authuser, 'stripe');

            $order_item_ids = $order->storeItems($cart, $authuser);

            if (count($onetime_products) != 0 && $cart->onetimeTotalPrice != 0) {
                $charge = $stripe->charges->create([
                    'amount' => $cart->onetimeTotalPrice * 100,
                    'customer' => $customer->id,
                    'currency' => 'usd',
                ]);
                $order->updateOnetimeItemsStatusAsPaid();

                $transaction = new Transaction();
                $transaction->storeOnetimeCharge($cart, $authuser, $charge->id, $order, 'stripe')
                    ->makeInvoice();

                foreach ($onetime_products as $key => $item) {
                    $this->storeOrderItem($item, $authuser, $order_item_ids[$key], $key);
                }
            }
            if (count($recurrent_products) != 0 && $cart->subTotalPrice != 0) {
                foreach ($recurrent_products as $key => $item) {
                    $subscription = $stripeClient->stripe->subscriptions->create([
                        'customer' => $customer->id,
                        'items' => [
                            ['price' => $item['parameter']['plan_id']],
                        ],
                    ]);

                    $orderItem = OrderItem::where('order_item_id', $key)
                        ->where('order_id', $order->id)
                        ->where('recurrent', 1)
                        ->first();

                    if ($orderItem) {
                        $orderItem->agreement_id = $subscription->id;
                        $orderItem->status = 'pending';
                        $orderItem->paid = 1;
                        $orderItem->save();
                    }

                    $this->storeOrderItem($item, $authuser, $order_item_ids[$key], $key);
                }
            }

            if ($new == 1) {
                $authuser->notifyNewUser();
            }

            $this->sendNotification($authuser, $order);

            return response()->json([
                'status' => 1,
                'data' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => json_encode($e->getMessage()),
            ]);
        }
    }

    public function sendNotification($authuser, $order)
    {
        \Log::info('payment notification');
    }

    public function storeOrderItem($item, $authuser, $order_item_id, $key)
    {
        $model = $this->typeToModel($item['type']);

        $orderItem = OrderItem::find($order_item_id);
        $model->storeItemFromPurchase($item, $authuser, $orderItem);

        $oldCart = session('cart');
        $cart = new Cart($oldCart);
        $cart->removeOne($key);

        session()->put(['cart' => $cart]);
    }

    public function typeToModel($type)
    {
        switch ($type) {
            case 'blogPackage':
                $item = new UserBlogPackage();
                break;
            case 'directoryPackage':
                $item = new UserDirectoryPackage();
                break;
            case 'blogAds':
                $item = new BlogAdsListing();
                break;
            case 'siteAds':
                $item = new SiteAdsListing();
                break;
            case 'directoryAds':
                $item = new DirectoryAdsListing();
                break;
            case 'product':
                $item = new UserProduct();
                break;
            default:
                $item = new UserEcommerceProduct();
        }

        return $item;
    }

    public function paypalGetUrl(Request $request)
    {
        $cart = session('cart');
        $recurrent_products = collect($cart->items)->where('recurrent', 1)->reverse()->toArray();
        $onetime_products = collect($cart->items)->where('recurrent', 0)->reverse()->toArray();

        session()->put(['paypalguestemail' => $request->get('guest_email')]);

        $orderId = guid();
        session()->put(['paypalCart'.$orderId => $cart]);

        if (count($onetime_products) != 0 && $cart->onetimeTotalPrice != 0) {
            $paypal = new Paypal();
            $provider = $paypal->getProvider();

            $data = [];

            $products = [];
            foreach ($onetime_products as $key => $item) {
                $product['name'] = $item['front'];
                $product['price'] = $item['price'];
                $product['desc'] = $item['front'];
                $product['qty'] = $item['quantity'];

                array_push($products, $product);
            }
            $data['items'] = $products;
            $data['invoice_id'] = $orderId.'--'.'0';
            $data['invoice_description'] = "Order #{$orderId} onetime product checkout";
            $data['return_url'] = route('cart.paypal.execute');
            $data['cancel_url'] = route('cart.checkout');
            $total = 0;
            foreach ($data['items'] as $item_detail) {
                $total += $item_detail['price'] * $item_detail['qty'];
            }
            $data['total'] = $total;

            session()->put(['paypalOrder'.$data['invoice_id'] => $data]);

            $response = $provider->setExpressCheckout($data, false);
            $approvalUrl0 = $response['paypal_link'];
        }
        if (count($recurrent_products) != 0 && $cart->subTotalPrice != 0) {
            $count = 0;
            $approvalUrl1 = [];

            foreach ($recurrent_products as $key => $item) {
                $paypal = new Paypal();
                $provider = $paypal->getProvider();
                $data = [];

                $data['items'] = [
                    [
                        'name' => $item['front'],
                        'price' => $item['price'],
                        'qty' => $item['quantity'],
                        'desc' => $item['front'],
                    ],
                ];

                $data['invoice_id'] = $orderId.'--'.$key;
                $data['invoice_description'] = "Order #{$orderId} recurring product checkout";
                $data['return_url'] = route('cart.paypal.execute');
                $data['cancel_url'] = route('cart.checkout');
                $data['notify_url'] = route('ipn.paypal');

                $total = 0;
                foreach ($data['items'] as $item_detail) {
                    $total += $item_detail['price'] * $item_detail['qty'];
                }

                $data['no_shipping'] = 1;
                $data['total'] = $total;

                session()->put(['paypalOrder'.$data['invoice_id'] => $data]);
                session()->put(['paypalItem'.$data['invoice_id'] => $item]);

                $response = $provider->setExpressCheckout($data, true);

                $approvalUrl1[$count] = $response['paypal_link'];
                $count++;
            }

            session()->put(['paypal-approvalUrl' => $approvalUrl1]);
            session()->put(['paypal-recurrent-execute' => true]);
        }

        if (isset($approvalUrl0)) {
            session()->put(['paypal-onetime-execute' => true]);
            $redirect = $approvalUrl0;
        } elseif (isset($approvalUrl1)) {
            session()->forget('paypal-onetime-execute');
            $redirect = $approvalUrl1[0];
        } else {
            return back()->with('error', 'Sorry, paypal config credentials are wrong');
        }

        return redirect($redirect);
    }

    public function paypalExecute(Request $request)
    {
        $token = $request->token;
        $payerId = $request->PayerID;
        if (empty($token)) {
            return redirect()->route('cart.checkout')->with('error', 'Session is expired');
        }

        $paypal = new Paypal();
        $provider = $paypal->getProvider();
        $checkoutDetail = $provider->getExpressCheckoutDetails($token);

        $invoice_id = $checkoutDetail['INVNUM'];
        $invoice_nums = explode('--', $invoice_id);

        $cart = session('paypalCart'.$invoice_nums[0]);

        $guest_email = session('paypalguestemail');
        if ($guest_email == null) {
            $guest_email = $checkoutDetail['EMAIL'];
        }
        $usermodel = new User();
        $getuserinfo = $usermodel->getPurchaseUser($guest_email);
        $authuser = $getuserinfo['user'];
        $new = $getuserinfo['new'];

        if (session()->has('paypal-onetime-execute')) {
            $data = session('paypalOrder'.$invoice_id);
            $resp = $provider->doExpressCheckoutPayment($data, $token, $payerId);

            $new_order = new Order();
            $order = $new_order->savePaypalOnetimeOrder($cart, $authuser);
            session()->put(['paypalCurrentOrderId' => $order->id]);

            $order_item_ids = $order->storePaypalOnetimeOrderItems($cart, $authuser);

            $transaction = new Transaction();
            $transaction->storeOnetimeCharge($cart, $authuser, $resp['PAYMENTINFO_0_TRANSACTIONID'], $order, 'paypal')
                ->makeInvoice();

            $onetime_products = collect($cart->items)->where('recurrent', 0)->reverse()->toArray();

            foreach ($onetime_products as $key => $item) {
                $this->storeOrderItem($item, $authuser, $order_item_ids[$key], $key);
            }

            session()->forget('paypal-onetime-execute');

            if (session()->has('paypal-recurrent-execute')) {
                return redirect(session('paypal-approvalUrl')[0]);
            }
        }

        if (session()->has('paypal-recurrent-execute')) {
            if (session()->has('paypal-count')) {
                session()->put(['paypal-count' => session('paypal-count') + 1]);
            } else {
                session()->put(['paypal-count' => 0]);
            }
            $data = session('paypalOrder'.$invoice_id);
            $item = session('paypalItem'.$invoice_id);

            if ($item['type'] == 'ecommerce') {
                $price = $item['parameter']['price'];
            } else {
                $price = $item['parameter'];
            }
            if ($price->period_unit == 'day') {
                $startdate = Carbon::now()->addDays($price->period)->toAtomString();
            } elseif ($price->period_unit == 'week') {
                $startdate = Carbon::now()->addWeeks($price->period)->toAtomString();
            } elseif ($price->period_unit == 'year') {
                $startdate = Carbon::now()->addYears($price->period)->toAtomString();
            } else {
                $startdate = Carbon::now()->addMonths($price->period)->toAtomString();
            }

            $detail = [
                'PROFILESTARTDATE' => $startdate,
                'DESC' => $data['invoice_description'],
                'BILLINGPERIOD' => ucfirst($price->period_unit), // Can be 'Day', 'Week', 'SemiMonth', 'Month', 'Year'
                'BILLINGFREQUENCY' => $price->period, //
                'AMT' => $price->price, // Billing amount for each billing cycle
                'CURRENCYCODE' => 'USD', // Currency code
            ];

            $resp1 = $provider->doExpressCheckoutPayment($data, $token, $payerId);

            $resp2 = $provider->createRecurringPaymentsProfile($detail, $token);
            \Log::info($resp2);
            if (session()->has('paypalCurrentOrderId')) {
                $orderId = session('paypalCurrentOrderId');
                $order = Order::find($orderId);
                $order = $order->addPaypalRecurrentOrder($cart, $authuser, $item);
            } else {
                $new_order = new Order();
                $order = $new_order->savePaypalRecurrentOrder($cart, $authuser, $item);
                session()->put(['paypalCurrentOrderId' => $order->id]);
            }
            $orderItem = $order->storePaypalRecurrentOrderItem($item, $authuser, $invoice_nums[1], $resp2['PROFILEID'] ?? 0);
            $this->storeOrderItem($item, $authuser, $orderItem->id, $orderItem->order_item_id);

            if ($resp1['ACK'] == 'Success') {
                $orderItem->storePaypalIpnPayment($startdate, $resp1['PAYMENTINFO_0_TRANSACTIONID'], $resp2['PROFILEID'] ?? 0, $resp1['PAYMENTINFO_0_AMT'], $authuser->id);
            }

            if (isset(session('paypal-approvalUrl')[session('paypal-count') + 1])) {
                return redirect(session('paypal-approvalUrl')[session('paypal-count') + 1].'#/checkout/review');
            }
        }

        if ($new == 1) {
            $authuser->notifyNewUser();
        }

        foreach (session()->all() as $key3 => $value) {
            if (strpos($key3, 'paypal') === 0) {
                session()->forget($key3);
            }
        }
        $this->sendNotification($authuser, $order);

        if (auth()->check()) {
            return redirect()->route('user.dashboard')->with('success', 'Successfully paid!');
        } else {
            return redirect()->route('login')->with('success', 'Successfully paid! Please check your mail box to get credentials.');
        }
    }
}
