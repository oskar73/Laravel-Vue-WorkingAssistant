<?php

namespace App\Integration;

class Stripe
{
    public $stripe;

    public $stripe_client_id;

    public $stripe_secret_key;

    public function __construct()
    {
        $stripe = primary_option('stripe', null);
        $this->stripe_secret_key = optional($stripe)['secret'];

        $this->stripe = new \Stripe\StripeClient(
            $this->stripe_secret_key
        );
    }

    public function createPlan($period, $period_unit, $price, $name)
    {
        return $this->stripe->plans->create([
            'amount' => $price * 100,
            'currency' => 'usd',
            'interval' => $period_unit,
            'interval_count' => $period,
            'product' => [
                'name' => $name,
            ],
        ]);
    }

    public function retrievePlan($plan_id)
    {
        return $this->stripe->plans->retrieve($plan_id, []);
    }

    public function deleteProduct($prod_id)
    {
        return $this->stripe->products->delete($prod_id, []);
    }

    public function deletePlan($plan_id)
    {
        $plan = $this->retrievePlan($plan_id);
        $prod_id = $plan->product;
        $plan->delete();

        return $this->deleteProduct($prod_id);
    }

    public function cancelSubscription($sub_id)
    {
        $resp = $this->stripe->subscriptions->cancel($sub_id, []);

        return $resp->status == 'canceled' ? 1 : 0;
    }

    public function setWebhook()
    {
        return $this->stripe->webhookEndpoints->create([
            'url' => route('ipn.stripe'),
            'enabled_events' => [
                'invoice.paid',
            ],
        ]);
    }
}
