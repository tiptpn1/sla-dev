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

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    $average = $activity->progress->avg('persentase');
                    $activity->percent_complete = round($average ?? 0, 2);
                }
            }
        }

        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];

        return view('dashboard.progress-activity', compact('projects', 'progressColors'));
    }

    public function ganchart(Request $request)
    {
        // dd(session()->all());
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');

        $query = Proyek::with([
            'scopes' => function ($query) use ($adminAccess, $subDivisiId) {
                $query->where('isActive', 1);

                // Jika akses sub divisi, filter scope berdasarkan sub_bagian_id
                if (in_array($adminAccess, [7, 9]) && $subDivisiId) {
                    $query->where('sub_bagian_id', $subDivisiId);
                }
            },
            'scopes.activities' => function ($query) use ($adminAccess) {
                if ($adminAccess != 2) {
                    $query->where('isActive', 1);
                }
            },
            'scopes.activities.pics',
            'scopes.activities.pics.bagian',
            'scopes.activities.progress' => fn($q) => $q->latest('tanggal'),
            'scopes.activities.progress.evidences' => fn($q) => $q->latest('created_at'),
        ])->where('isActive', true);
        
        // Filter berdasarkan hak akses
        if (in_array($adminAccess, [3, 10]) && $bagianId) {
            $query->where('master_nama_bagian_id', $bagianId);
        } elseif ($adminAccess == 6 && $direktoratId) {
            $query->where('direktorat_id', $direktoratId);
        } elseif (in_array($adminAccess, [7, 9]) && $subDivisiId) {
            $query->whereHas('scopes', function ($q) use ($subDivisiId) {
                $q->where('isActive', 1)
                  ->where('sub_bagian_id', $subDivisiId);
            });
        }

        $projects = $query->get();
        // Loop untuk hitung rata-rata
        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    $average = $activity->progress->avg('persentase');
                    $activity->percent_complete = round($average ?? 0, 2);
                }
            }
        }
        return view('pages.ganchart.dashboard', compact('projects'));
    }
}

