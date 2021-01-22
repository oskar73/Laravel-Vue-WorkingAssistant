<?php

namespace App\View\Components\Front;

use App\Models\Slider;
use Illuminate\View\Component;

class Feature extends Component
{
    public $sliders;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sliders = Slider::with('model', 'media')
            ->orderBy('order')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.feature');
    }
}
