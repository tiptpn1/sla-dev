<?php

namespace App\View\Components\Activity;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityTable extends Component
{
    public $id;
    public $activities;
    public $scopeId;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $activities, $scopeId)
    {
        $this->id = $id;
        $this->activities = $activities;
        $this->scopeId = $scopeId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.activity.activity-table');
    }
}
