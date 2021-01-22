<?php

namespace App\View\Components\Account;

use Illuminate\View\Component;

class Notification extends Component
{
    public $unreads;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->unreads = user()->unreadNotifications;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.account.notification');
    }
}
