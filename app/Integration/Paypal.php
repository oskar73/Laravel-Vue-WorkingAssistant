<?php

namespace App\Integration;

use Srmklive\PayPal\Services\ExpressCheckout;

class Paypal
{
    public $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout;
        $options = [
            'BRANDNAME' => tenant('name'),
            'LOGOIMG' => optional(option('basic', null))['logo'] ?? asset('assets/img/default_logo.png'),
            'CHANNELTYPE' => 'Merchant',
        ];
        $paypal = option('paypal', null);
        $mode = optional($paypal)['sandbox'];

        $config['mode'] = $mode;
        $config[$mode]['username'] = optional($paypal)['username'];
        $config[$mode]['password'] = optional($paypal)['password'];
        $config[$mode]['secret'] = optional($paypal)['secret'];

        $config['payment_action'] = 'Sale';
        $config['currency'] = 'USD';
        $config['billing_type'] = 'MerchantInitiatedBilling';
        $config['notify_url'] = route('ipn.paypal');
        $config['locale'] = '';
        $config['validate_ssl'] = true;

        $this->provider->setApiCredentials($config);
        $this->provider->addOptions($options);
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function cancelSubscription($sub_id)
    {
        $resp = $this->provider->cancelRecurringPaymentsProfile($sub_id);

        return $resp['ACK'] == 'Success' ? 1 : 0;
    }
}
