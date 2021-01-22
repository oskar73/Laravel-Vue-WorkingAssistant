<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubscribePost extends Component
{
    public $isSubscribed;

    public $subscribers_count;

    public $post;

    public function mount($post)
    {
        $this->post = $post;
    }

    public function render()
    {
        if (\Auth::check()) {
            $this->isSubscribed = user()->hasSubscribed($this->post);
        } else {
            $this->isSubscribed = false;
        }
        $this->subscribers_count = $this->post->subscribers()->count();

        return view('livewire.subscribe-post');
    }

    public function toggle()
    {
        if (\Auth::check()) {
            user()->toggleSubscribe($this->post);
        } else {
            \Session::put('url.intended', url()->previous());

            return redirect()->to('/login');
        }
    }
}
