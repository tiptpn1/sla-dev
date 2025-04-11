<?php

namespace App\View\Components;

use App\Models\Proyek;
use Closure;
use Illuminate\Support\Facades\Session;
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
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $subDivisiId = Session::get('id_sub_divisi'); 

        $query = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', true);
            },
            'scopes.activities' => function ($query) {
                $query->where('isActive', true);
            },
        ])->where('isActive', true);

        // Apply filter berdasarkan hak akses
        if ($adminAccess == 6 && $direktoratId) {
            $query->where('direktorat_id', $direktoratId);
        } elseif ($adminAccess == 3 && $bagianId) {
            $query->where('master_nama_bagian_id', $bagianId);
        } elseif ($adminAccess == 7 && $subDivisiId) {
            $query->where('id_sub_divisi', $subDivisiId);
        }

        $projects = $query->get();
        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];

        return view('components.progress-activity', compact('projects', 'progressColors'));
    }


}
