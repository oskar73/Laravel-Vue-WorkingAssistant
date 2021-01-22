<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Integration\Stripe;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\EcommerceCustomer;
use App\Models\Module\EcommercePayment;
use App\Models\StripeAccount;
use App\Models\AccountBalance;
use App\Models\AccountTransfer;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends AdminController
{
    public function __construct(EcommercePayment $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $payments = $this->model
                ->with(['customer', 'order'])
                ->orderBy('created_at', 'DESC')
                ->get();

            // $activePayments = $payments->where('status', 1);
            // $inactivePayments = $payments->where('status', 0);

            $all = view('components.admin.ecommercePayment', [
                'payments' => $payments,
                'selector' => 'datatable-all',
            ])->render();
            // $active = view('components.admin.ecommerceProduct', [
            //     'payments' => $activePayments,
            //     'selector' => 'datatable-active',
            // ])->render();
            // $inactive = view('components.admin.ecommerceProduct', [
            //     'payments' => $inactivePayments,
            //     'selector' => 'datatable-inactive',
            // ])->render();

            $count['all'] = $payments->count();
            // $count['active'] = $activePayments->count();
            // $count['inactive'] = $inactivePayments->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                // 'active' => $active,
                // 'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'ecommerce.payment');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    /**
     * @deprecated: Not used, payment directly paid to connected account
     */
    public function withdraw(Request $request)
    {
        try {
            $account = StripeAccount::where('user_id', user()->id)->where('web_id', tenant('id'))->first();

            $balance = AccountBalance::where('user_id', user()->id)->where('web_id', tenant('id'))->first();

            if ($balance->amount) {
                $account_transfer = AccountTransfer::create([
                    'web_id'    =>  tenant('id'),
                    'user_id'   =>  user()->id,
                    'amount'    =>  $balance->amount,
                    'method'    =>  'stripe',
                    'type'      =>  'ecommerce.module'
                ]);
    
                try {
                    $stripeClient = new Stripe();
    
                    $transfer = $stripeClient->stripe->transfers->create([
                        'amount'    =>  $balance->amount,
                        'currency'  =>  'usd',
                        'destination'   =>  $account->stripe_id,
                        'metadata'  =>  [
                            'id'  =>  $account_transfer->id,
                        ]
                    ]);
                } catch (\Exception $e) {
                    \Log::info('stripe transfer failed');
                    \Log::info(json_encode($e->getMessage()));
                    AccountTransfer::destroy($transfer->id);
                    return response()->json([
                        'success'   =>  false,
                    ]);
                }
    
                $account_transfer->payment_id = $transfer->id;
                $account_transfer->save();
    
                $balance->pending_amount = $balance->amount;
                $balance->amount = 0;
                $balance->save();

                $payments = EcommercePayment::where('web_id', tenant('id'))->where('payment_status', 'succeeded')->get();
                foreach($payments as $payment) {
                    $payment->payment_status = 'pending';
                    $payment->transfer_id = $account_transfer->id;
                    $payment->save();
                }
            }

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            \Log::info('PaymentController withdraw failed');
            \Log::info(json_encode($e->getMessage()));
            return response()->json([
                'success'   =>  false,
            ]);
        }
    }
}
