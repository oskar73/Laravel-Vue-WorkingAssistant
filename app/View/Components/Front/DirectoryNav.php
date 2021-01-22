<?php

namespace App\View\Components\Front;

use App\Models\DirectoryCategory;
use App\Models\DirectoryTag;
use Illuminate\View\Component;

class DirectoryNav extends Component
{
    public $categories;

    public $tags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = DirectoryCategory::where('parent_id', 0)
            ->with('approvedSubCategories.approvedTags', 'approvedTags', 'media', 'approvedSubCategories.media')
            ->status(1)
            ->get(['id', 'name', 'slug', 'description']);

        $this->tags = DirectoryTag::whereStatus(1)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.directory-nav');
    }
}
