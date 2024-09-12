<?php

namespace App\View\Components\Sla;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectScope extends Component
{
    public $scope;
    public $color;
    /**
     * Create a new component instance.
     */
    public function __construct($scope, $color)
    {
        $this->scope = $scope;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];
        return view('components.sla.project-scope', compact('progressColors'));
    }
}
