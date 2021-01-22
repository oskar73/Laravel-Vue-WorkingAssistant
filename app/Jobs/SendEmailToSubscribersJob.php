<?php

namespace App\Jobs;

use App\Mail\BasicMail;
use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emails;

    public $slug;

    public $post;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $post, $data, $slug)
    {
        $this->emails = $emails;
        $this->post = $post;
        $this->slug = $slug;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = NotificationTemplate::where('slug', $this->slug)->first();
        if ($template != null) {
            $body = $template->body;

            $data = $this->data;
            $data['title'] = $this->post->title;
            $data['user'] = $this->post->user->name ?? '';
            $data['unsubscribe'] = \URL::signedRoute('unsubscribe');

            foreach ($data as $key => $item) {
                $body = str_replace('{'.$key.'}', $item, $body);
            }
            $fromMail = $template->fromMail ?? 'info';
            $data2['body'] = $body;
            $data2['subject'] = $template->subject;
            $data2['fromName'] = $template->fromName ?? 'Bizinabox';
            $data2['fromMail'] = $fromMail.'@bizinabox.com';

            $object = new BasicMail($data2);

            foreach ($this->emails as $email) {
                Mail::to($email)->send($object);
            }
        }
    }
}
