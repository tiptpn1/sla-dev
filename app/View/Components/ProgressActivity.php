<?php

namespace App\View\Components;

use App\Models\Proyek;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProgressActivity extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $projects = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', true);
            }
        ])->where('isActive', true)->get();

        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];

        return view('components.progress-activity', compact('projects', 'progressColors'));
    }
}
