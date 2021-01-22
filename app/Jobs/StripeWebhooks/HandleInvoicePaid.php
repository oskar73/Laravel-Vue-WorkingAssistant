<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class HandleInvoicePaid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $webhookCall;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $data = $this->webhookCall->payload['data']['object'];

            $orderItem = new OrderItem();
            $item = $orderItem->updateSubscriptionStatus($data);

            $transaction = new Transaction();
            $transaction->storeSubscriptionCharge($data['charge'], $data['subscription'], $data['amount_paid'] / 100, $item->user_id, 'stripe')
                ->makeInvoice();
        } catch (\Exception $e) {
            \Log::info(json_encode($e->getMessage()));
        }
    }
}
