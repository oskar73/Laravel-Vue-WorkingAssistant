<?php

namespace App\Jobs;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $detail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $category_id = $this->detail['category'];
//        $un_subscribers = \DB::table("unsubscribe_category")
//            ->where("category_id", $category_id)
//            ->pluck("subscriber_id")
//            ->toArray();
//
//        $subscribers = Subscriber::where("status", 1)
//            ->whereNotIn("id", $un_subscribers)
//            ->get();
        $subscribers = Subscriber::where('status', 1)
            ->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send($this->detail['object']);
        }
    }
}
