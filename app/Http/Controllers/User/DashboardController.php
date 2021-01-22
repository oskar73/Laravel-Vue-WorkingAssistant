<?php

namespace App\Http\Controllers\User;

use App\Models\Ticket;

class DashboardController extends UserController
{
    public function index()
    {
        $data['openedTickets'] = Ticket::with('user')
            ->where('parent_id', 0)
            ->where(function ($q) {
                $q->where('is_read', 0);
                $q->orWhere('status', '!=', 'closed');
            })
            ->my()
            ->latest()
            ->get();
        $data['notifications'] = auth()->user()->unreadNotifications;

        return view(self::$viewDir.'.dashboard', $data);
    }
}
