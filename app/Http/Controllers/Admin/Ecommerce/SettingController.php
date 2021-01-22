<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Integration\Stripe;
use App\Integration\PaypalV2;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\EcommerceCustomer;
use App\Models\Module\EcommercePayment;

use App\Models\Website;
use App\Models\StripeAccount;
use App\Models\PaypalAccount;

use Illuminate\Http\Request;
use Validator;

class SettingController extends AdminController
{
    public function index()
    {
        $gateway = primary_option('gateway', []);
        $stripeAccount = StripeAccount::where('user_id', user()->id)->where('web_id', tenant('id'))->first();
        $paypalAccount = PaypalAccount::where('user_id', user()->id)->where('web_id', tenant('id'))->first();

        return view(self::$viewDir.'ecommerce.setting', compact('stripeAccount', 'paypalAccount', 'gateway'));
    }

    public function accountLink(Request $request)
    {
        try {
            $website = tenant();

            if (is_null($website)) {
                return response()->json([
                    'success'   =>  false,
                    'web'=>$website,
                    'user'  =>  user()->id
                ]);
            }

            $url = '';
            if ($request->type == 'stripe') {
                $stripeClient = new Stripe();
                $stripeAccount = StripeAccount::where('user_id', user()->id)->where('web_id', tenant()->id)->first();
                if (is_null($stripeAccount)) {
                    $account = $stripeClient->stripe->accounts->create([
                        'type'      =>  'express',
                        'country'   =>  'US',
                        'business_profile'  =>  [
                            'url'   =>  'https://'.$website->domain,
                        ],
                        'capabilities'  =>  [
                            'card_payments' =>  [
                                'requested' =>  true
                            ],
                            'transfers' =>  [
                                'requested' =>  true
                            ]
                        ],
                        'metadata'  =>  [
                            'user'  =>  user()->id,
                            'web'   =>  tenant('id')
                        ]
                    ]);
                    StripeAccount::create([
                        'web_id'    =>  tenant('id'),
                        'user_id'   =>  user()->id,
                        'stripe_id' =>  $account->id
                    ]);
                    $accountId = $account->id;
                } else {
                    $accountId = $stripeAccount->stripe_id;
                }
    
                $accountLink = $stripeClient->stripe->accountLinks->create([
                    'account'       =>  $accountId,
                    'refresh_url'   =>  route('admin.ecommerce.setting.index'),
                    'return_url'    =>  route('admin.ecommerce.setting.index'),
                    'type'          =>  'account_onboarding'
                ]);
                $url = $accountLink->url;
            } else if ($request->type == 'paypal') {
                $paypalClient = new PaypalV2();
                $response = $paypalClient->getOnboardingSignupLink();
                $url = $response['links'][1]['href'];
            }

            return response()->json([
                'success' => true,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            \Log::info('SettingController account link failed');
            \Log::info(json_encode($e->getMessage()));
            return response()->json([
                'success'   =>  false,
            ]);
        }
    }

    public function accountLogin(Request $request)
    {
        $type = $request->type;
        if ($type == 'stripe') {
            try {
                $stripeClient = new Stripe();
                $stripeAccount = StripeAccount::where('user_id', user()->id)->where('web_id', tenant()->id)->first();
                
                $link = $stripeClient->stripe->accounts->createLoginLink($stripeAccount->stripe_id, []);
                $url = $link->url;
            } catch (\Exception $e) {
                \Log::info('SettingController stripe account login failed');
                \Log::info(json_encode($e->getMessage()));
                return response()->json([
                    'success'   =>  false,
                ]);
            }
        } else if ($type == 'paypal') {
            // try {
            //     $paypalClient = new PaypalV2();
            //     $response = $paypalClient->getOnboardingSignupLink();
            //     $url = $response['links'][1]['href'];
            // } catch (\Exception $e) {
            //     \Log::info('SettingController paypal account login failed');
            //     \Log::info(json_encode($e->getMessage()));
            //     return response()->json([
            //         'success'   =>  false,
            //     ]);
            // }
        }

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }

    public function accountPaypalConnect(Request $request) {
        $merchantId = $request->input('merchantId');
        $merchantIdInPayPal = $request->input('merchantIdInPayPal');

        $paypal = new PaypalV2();
        $status = $paypal->sellerOnboardingStatus($merchantIdInPayPal);
        if (!isset($status['payments_receivable'])) {
            return redirect()->route('admin.ecommerce.setting.index');
        }

        $paypalAccount = PaypalAccount::where('merchant_id', $merchantId)->where('merchant_paypal_id', $merchantIdInPayPal)->first();
        if (!is_null($paypalAccount) && $paypalAccount->user_id !== user()->id) {
            return redirect()->route('admin.ecommerce.setting.index');
        }

        if (is_null($paypalAccount)) {
            PaypalAccount::create([
                'web_id'    =>  tenant()->id,
                'user_id'   =>  user()->id,
                'merchant_id'   =>  $merchantId,
                'merchant_paypal_id'   =>  $merchantIdInPayPal,
                'payments_receivable'   =>  $status['payments_receivable'],
                'primary_email_confirmed'   =>  $status['primary_email_confirmed'],
                'permission_granted'    =>  isset($status['oauth_integrations'][0])
            ]);
        } else {
            $paypalAccount->merchant_id = $merchantId;
            $paypalAccount->merchant_paypal_id = $merchantIdInPayPal;
            $paypalAccount->payments_receivable = $status['payments_receivable'];
            $paypalAccount->primary_email_confirmed = $status['primary_email_confirmed'];
            $paypalAccount->permission_granted = isset($status['oauth_integrations'][0]);
            $paypalAccount->save(); 
        }

        return redirect()->route('admin.ecommerce.setting.index');
    }
}
