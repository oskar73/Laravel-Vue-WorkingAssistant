<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FavoritePost extends Component
{
    public $isFavorite;

    public $favorite_count;

    public $post;

    public function mount($post)
    {
        $this->post = $post;
    }

    public function render()
    {
        if (\Auth::check()) {
            $this->isFavorite = user()->hasFavorited($this->post);
        } else {
            $this->isFavorite = false;
        }
        $this->favorite_count = $this->post->favoriters()->count();

        return view('livewire.favorite-post');
    }

    public function toggle()
    {
        if (\Auth::check()) {
            user()->toggleFavorite($this->post);
        } else {
            \Session::put('url.intended', url()->previous().'#like-area');

            return redirect()->to('/login');
        }
    }
}
