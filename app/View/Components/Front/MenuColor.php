<?php

namespace App\View\Components\Front;

use App\Models\Color;
use Illuminate\View\Component;

class MenuColor extends Component
{
    public $menu_color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $color = Color::where('type', 'menu')->where('default', 1)->first();
        $this->menu_color = optional($color->color ?? '');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.menu-color', [
            'menu_color' => $this->menu_color,
        ]);
    }
}
