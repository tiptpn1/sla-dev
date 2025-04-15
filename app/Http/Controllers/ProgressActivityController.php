<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProgressActivityController extends Controller
{
    
    public function index(Request $request)
    {
        // dd(session()->all());
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id'); 

        $year = $request->input('year', date('Y'));

        $projects = Proyek::with(['scopes.activities.progress', 'scopes.activities.pics.bagian'])
            ->whereYear('created_at', $year) 
            ->get();

            $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];

         return view('dashboard.progress-activity', compact('projects', 'progressColors'));
    }

    public function ganchart(Request $request)
    {
        // dd(session()->all());
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id'); 

        $year = $request->input('year', date('Y'));

        if ($adminAccess == 6 ) {
            // Jika admin direktorat, hanya tampilkan proyek dan scope dari direktoratnya
            $projects = Proyek::with([
                'scopes' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities' => function($query) use ($bagianId) {
                    $query->where('isActive', true)
                          ->whereHas('pics', function($q) use ($bagianId) {
                              $q->where('bagian_id', $bagianId);
                          });
                },
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->where('direktorat_id', $direktoratId)
            ->whereYear('created_at', $year)
            ->get();

        } elseif ($adminAccess == 3) {
            // Jika admin divisi, tampilkan proyek dan scope dari bagian yang diakses
            $projects = Proyek::with([
                'scopes' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities' => function($query) use ($bagianId) {
                    $query->where('isActive', true)
                          ->whereHas('pics', function($q) use ($bagianId) {
                              $q->where('bagian_id', $bagianId);
                          });
                },
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->where('master_nama_bagian_id', $bagianId)
            ->whereYear('created_at', $year)
            ->get();
        } else {
            // Jika bukan admin direktorat, tampilkan semua proyek aktif
            $projects = Proyek::with(['scopes' => function($query) {
                                $query->where('isActive', true);
                            }, 
                            'scopes.activities' => function($query) {
                                $query->where('isActive', true);
                            }, 
                            'scopes.activities.pics', 
                            'scopes.activities.progress', 
                            'scopes.activities.progress.evidences'])
                            ->where('isActive', true)
                            ->whereYear('created_at', $year)
                            ->get();
        }
        // dd($projects);

        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];
        return view('pages.ganchart.dashboard', compact('projects', 'progressColors'));
    }
}

