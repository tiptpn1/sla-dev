<?php

namespace App\View\Components\Activity;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectAccordion extends Component
{
    public $project;
    public $alphabet;
    /**
     * Create a new component instance.
     */
    public function __construct($project, $alphabet)
    {
        $this->project = $project;
        $this->alphabet = $alphabet;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.activity.project-accordion');
    }
}
