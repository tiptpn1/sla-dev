<?php

namespace App\View\Components\Activity;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScopeAccordion extends Component
{
    public $scope;
    public $tableId;

    /**
     * Create a new component instance.
     */
    public function __construct($scope, $tableId)
    {
        $this->scope = $scope;
        $this->tableId = $tableId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.activity.scope-accordion');
    }
}
