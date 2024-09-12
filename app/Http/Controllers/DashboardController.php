<?php

namespace App\Http\Controllers;

use App\Models\Eviden;
use App\Models\Proyek;
use App\Traits\RoleTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd(session()->all());
        // $projects = Proyek::with([
        //     'scopes' => function ($query) {
        //         $query->where('isActive', 1);
        //     },
        //     'scopes.activities',
        //     'scopes.activities.pics',
        //     'scopes.activities.pics.bagian',
        //     'scopes.activities.progress' => function ($query) {
        //         $query->latest('created_at')->first();
        //     },
        //     'scopes.activities.progress.evidences' => function ($query) {
        //         $query->latest('created_at')->first();
        //     }
        // ])->where('is_active', true)->get();

        // return response()->json($projects);

        return view('dashboard.index',);
    }

    public function ganchart()
    {
        // Data aktivitas dengan start, durasi dalam minggu, dan perhitungan tanggal akhir
        $activities = [
            ['id' => 1, 'text' => 'Activity 1', 'start_date' => '2024-02-08', 'duration_weeks' => 8],
            ['id' => 2, 'text' => 'Activity 2', 'start_date' => '2024-01-15', 'duration_weeks' => 4],
            // Tambahkan aktivitas lain sesuai kebutuhan
        ];

        // Hitung end_date berdasarkan start_date dan duration_weeks
        foreach ($activities as &$activity) {
            $startDate = new \DateTime($activity['start_date']);
            $endDate = $startDate->modify("+{$activity['duration_weeks']} weeks");
            $activity['end_date'] = $endDate->format('Y-m-d');
        }

        return view('pages.ganchart.dashboard', compact('activities'));
    }
}
