<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HomeHero extends Component
{
    public function __construct()
    {
        // Add props here if needed in future
    }

    public function render(): View
    {
        return view('components.hero-page');
    }
}
