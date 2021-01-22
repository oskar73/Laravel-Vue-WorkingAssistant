<?php

namespace App\View\Components\Front;

use App\Models\Module\BlogPost;
use Illuminate\View\Component;

class BlogPopular extends Component
{
    public $popular_posts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->popular_posts = BlogPost::with('media', 'user')
            ->withCount('approvedComments', 'favoriters')
            ->whereStatus('approved')
            ->visible()
            ->whereIsPublished(1)
            ->orderBy('view_count', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.blog-popular');
    }
}
