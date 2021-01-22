<?php

namespace App\View\Components\Front;

use App\Models\Color;
use Illuminate\View\Component;

class ThemeColor extends Component
{
    public $theme_color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $color = Color::where('type', 'theme')->where('default', 1)->first();
        $this->theme_color = optional($color->color ?? '');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.theme-color', [
            'theme_color' => $this->theme_color,
        ]);
    }
}
