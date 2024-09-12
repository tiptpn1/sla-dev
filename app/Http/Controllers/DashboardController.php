<?php

namespace App\Http\Controllers;

use App\Models\Activity;
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
        $activities = Activity::all();
        return view('dashboard.index', compact('activities'));
    }

    public function ganchart()
    {
        $activities = [
            ['id' => 1, 'text' => 'Activity 1', 'plan_start' => '2024-02-08', 'plan_duration_weeks' => 8, 'actual_start' => '2024-02-15', 'actual_duration_weeks' => 7],
            ['id' => 2, 'text' => 'Activity 2', 'plan_start' => '2024-01-15', 'plan_duration_weeks' => 4, 'actual_start' => '2024-01-20', 'actual_duration_weeks' => 5],
            // Tambahkan aktivitas lain sesuai kebutuhan
        ];

        foreach ($activities as &$activity) {
            $startDate = new \DateTime($activity['plan_start']);
            $endDate = $startDate->modify("+{$activity['plan_duration_weeks']} weeks");
            $activity['plan_end_date'] = $endDate->format('Y-m-d');

            $startDate = new \DateTime($activity['actual_start']);
            $endDate = $startDate->modify("+{$activity['actual_duration_weeks']} weeks");
            $activity['actual_end_date'] = $endDate->format('Y-m-d');
        }

        $currentYear = date('Y');

        return view('pages.ganchart.dashboard', compact('activities', 'currentYear'));
    }
}
