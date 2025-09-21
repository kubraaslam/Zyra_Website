<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminNavLink extends Component
{
    /**
     * Create a new component instance.
     */

    public $href;
    public $route;
    public function __construct($href, $route)
    {
        $this->href = $href;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */

    public function render()
    {
        return view('components.admin-nav-link');
    }

    public function isActive()
    {
        return request()->routeIs($this->route);
    }
}
