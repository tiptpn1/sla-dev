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
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $subDivisiId = Session::get('id_sub_divisi');
        
        $year = $request->input('year', date('Y'));
        
        if ($adminAccess == 6) {
            // Untuk admin direktorat
            $projects = Proyek::with([
                'scopes' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->where('direktorat_id', $direktoratId)
            ->get();
        }
        elseif (($adminAccess == 7 || $adminAccess == 9) && $subDivisiId) {
            // Untuk admin sub divisi
            $projects = Proyek::with([
                'scopes' => function($query) use ($subDivisiId) {
                    $query->where('isActive', true)
                        ->where('sub_bagian_id', $subDivisiId);
                },
                'scopes.activities',
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->whereHas('scopes', function ($query) use ($subDivisiId) {
                $query->where('isActive', true)
                    ->where('sub_bagian_id', $subDivisiId);
            })
            ->whereYear('created_at', $year)
            ->get();
        }
        elseif (($adminAccess == 3 || $adminAccess == 10) && $bagianId) {
            // Untuk admin divisi dan admin dengan akses 10
            $projects = Proyek::with([
                'scopes' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities',
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->where('master_nama_bagian_id', $bagianId)
            ->get();
        }
        else {
            // Untuk hak akses lainnya (default)
            $projects = Proyek::with([
                'scopes' => function($query) {
                    $query->where('isActive', true);
                },
                'scopes.activities',
                'scopes.activities.pics',
                'scopes.activities.progress',
                'scopes.activities.progress.evidences'
            ])
            ->where('isActive', true)
            ->whereYear('created_at', $year)
            ->get();
        }

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {

                $activityCount = 0;
                $totalPercent = 0;

                foreach ($scope->activities as $activity) {
                    $average = $activity->progress->avg('persentase');
                    $activity->percent_complete = round($average ?? 0, 2);

                    $totalPercent += $activity->percent_complete;
                    $activityCount++;
                }

                // Hitung rata-rata percent_complete scope dari seluruh aktivitas di dalamnya
                $scope->percent_complete = $activityCount > 0 ? round($totalPercent / $activityCount, 2) : 0;
            }
        }
        
        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];
        return view('pages.ganchart.dashboard', compact('projects', 'progressColors'));
    }
}

