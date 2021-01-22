<?php

namespace App\View\Components\Front;

use Illuminate\View\Component;

class LegalNav extends Component
{
    public $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.front.legal-nav', [
            'data' => $this->data,
        ]);
    }
}
