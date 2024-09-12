<?php

namespace App\View\Components\Sla;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScopeActivity extends Component
{
    public $activity;
    public $color;
    /**
     * Create a new component instance.
     */
    public function __construct($activity, $color)
    {
        $this->activity = $activity;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.sla.scope-activity');
    }
}
