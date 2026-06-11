<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public string $title;
    public function render(): View
    {
        return view('layouts.guest');
    }
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');
    }
}
