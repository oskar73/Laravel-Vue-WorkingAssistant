<?php

namespace App\View\Components\Front;

use App\Models\Page;
use Illuminate\View\Component;

class DirectoryAdsHero extends Component
{
    public $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = optional(Page::firstOrCreate([
            'type' => 'module',
            'url' => 'directoryAds',
        ])->data);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.directory-ads-hero', [
            'data' => $this->data,
        ]);
    }
}
