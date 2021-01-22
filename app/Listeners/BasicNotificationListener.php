<?php

namespace App\Listeners;

use App\Events\BasicNotificationEvent;
use App\Notifications\BasicDatabaseNotification;
use App\Notifications\BasicEmailNotification;
use Illuminate\Support\Facades\Notification;

class BasicNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BasicNotificationEvent $event)
    {
        Notification::send($event->data['user'], new BasicDatabaseNotification($event->data['data']));
        Notification::send($event->data['user'], new BasicEmailNotification($event->data['data']));
    }
}
