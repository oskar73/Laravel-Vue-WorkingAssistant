<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Follower extends Component
{
    public $followers;

    public $user;

    protected $listeners = [
        'followerRefresh' => '$refresh',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $this->followers = $this->user->followers()->count();

        return view('livewire.follower');
    }
}
