<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\AdminController;
use App\Integration\Paypal;
use App\Integration\Stripe;
use App\Models\NotificationTemplate;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class SubscriptionController extends AdminController
{
    public function __construct(OrderItem $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getSubscriptionDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'purchase.subscription');
    }

    public function detail($id)
    {
        $subscription = $this->model->with('transactions.invoice')
            ->where('id', $id)
            ->where('recurrent', 1)
            ->firstorfail();

        return view(self::$viewDir.'purchase.subscriptionDetail', compact('subscription'));
    }

    public function cancel(Request $request)
    {
        try {
            $orderItem = $this->model->whereId($request->id)
                ->where('status', 'active')
                ->where('recurrent', 1)
                ->firstorfail();
            $status = 1;
            if ($orderItem->order->gateway == 'paypal') {
                $gateway = new Paypal();
                $status = $gateway->cancelSubscription($orderItem->agreement_id);
            } elseif ($orderItem->order->gateway == 'stripe') {
                $gateway = new Stripe();
                $status = $gateway->cancelSubscription($orderItem->agreement_id);
            }
            if ($status == 1) {
                $orderItem->status = 'canceled';
                $orderItem->save();

//                $notification = new NotificationTemplate();
//                $data['url'] = route('user.purchase.subscription.detail', $orderItem->id);
//                $data['username'] = $orderItem->user->name;
//
//                $notification->sendNotification($data, $notification::CANCEL_SUBSCRIPTION_USER, $orderItem->user);

                return response()->json([
                    'status' => 1,
                    'data' => $orderItem,
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'data' => ['Sorry, Something wrong!'],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
