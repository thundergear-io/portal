<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $title;

    public $clients;

    public $description;

    public $image;

    public $sidebar;

    public function __construct($title = '', $clients = false, $description = null, $image = null, $sidebar = false)
    {
        $this->title = $title;
        $this->clients = $clients ? true : false;
        $this->description = $description;
        $this->image = $image;
        $this->sidebar = $sidebar;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render()
    {
        return view('layouts.app', ['sidebar' => $this->sidebar]);
    }
}
