<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubscribeCategory extends Component
{
    public $isSubscribed;

    public $subscribers_count;

    public $category;

    public function mount($category)
    {
        $this->category = $category;
    }

    public function render()
    {
        if (\Auth::check()) {
            $this->isSubscribed = user()->hasSubscribed($this->category);
        } else {
            $this->isSubscribed = false;
        }
        $this->subscribers_count = $this->category->subscribers()->count();

        return view('livewire.subscribe-category');
    }

    public function toggle()
    {
        if (\Auth::check()) {
            user()->toggleSubscribe($this->category);
        } else {
            \Session::put('url.intended', url()->previous());

            return redirect()->to('/login');
        }
    }
}
