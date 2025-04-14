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

        $progressColors = [
            '#007bff', // biru
            '#28a745', // hijau
            '#ffc107', // kuning
            '#dc3545', // merah
            '#17a2b8', // cyan
            '#6f42c1', // ungu
        ];

         return view('dashboard.progress-activity', compact('projects', 'progressColors'));
    }

    public function ganchart()
    {
        // dd(session()->all());
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id'); 

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
                            ->get();
        }
        // dd($projects);

        $progressColors = [
            '#007bff', // biru
            '#28a745', // hijau
            '#ffc107', // kuning
            '#dc3545', // merah
            '#17a2b8', // cyan
            '#6f42c1', // ungu
        ];

        return view('pages.ganchart.dashboard', compact('projects', 'progressColors'));
    }
}

