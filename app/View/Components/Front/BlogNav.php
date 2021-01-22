<?php

namespace App\View\Components\Front;

use App\Models\BlogTag;
use App\Models\Module\BlogCategory;
use Illuminate\View\Component;

class BlogNav extends Component
{
    public $categories;

    public $tags;

    public $packageShow;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = BlogCategory::with('media')
            ->whereStatus(1)
            ->orderBy('order')
            ->get();

        $this->tags = BlogTag::whereStatus(1)
            ->get();

        $setting = optional(option('blog', null));

        $this->packageShow = $setting['permission'] == 'paid' || $setting['permission'] == 'both' ? 1 : 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.blog-nav');
    }
}
