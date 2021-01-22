<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;

class VerifiedUser
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
    public function handle(Verified $event)
    {
        $user = $event->user;
//        $user->addSubscriber(1);
    }
}
