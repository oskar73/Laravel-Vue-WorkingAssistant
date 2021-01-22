<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class Following extends Component
{
    public $following = true;

    public $user;

    protected $listeners = [
        'followingRefresh' => '$refresh',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        if (Auth::check() && user()->isFollowing($this->user)) {
            $this->following = true;
        } else {
            $this->following = false;
        }

        return view('livewire.following');
    }

    public function toggle()
    {
        if (Auth::check()) {
            if (user()->id == $this->user->id) {
                return back();
            } else {
                user()->toggleFollow($this->user);
                $this->emit('followerRefresh');
                $this->emit('followingRefresh');
            }
        } else {
            \Session::put('url.intended', url()->previous());

            return redirect()->to('/login');
        }
    }
}
