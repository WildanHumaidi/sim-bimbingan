<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonLink extends Component
{
    public $href;
    public $color;

    public function __construct($href, $color = 'blue')
    {
        $this->href = $href;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.button-link');
    }
}
