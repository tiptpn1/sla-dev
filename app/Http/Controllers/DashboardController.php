<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Eviden;
use App\Models\Proyek;
use App\Traits\RoleTrait;
use Carbon\Carbon;
use DateTime;
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
        $projects = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities',
            'scopes.activities.pics',
            'scopes.activities.pics.bagian',
            'scopes.activities.progress' => function ($query) {
                $query->latest('created_at')->first();
            },
            'scopes.activities.progress.evidences' => function ($query) {
                $query->latest('created_at')->first();
            }
        ])->where('isActive', true)->get();

        // return response()->json($projects);

        return view('dashboard.index', compact('projects'));
    }

    public function ganchart()
    {
        // Data aktivitas dengan start, durasi dalam minggu, dan perhitungan tanggal akhir
        $projects = Proyek::with(['scopes', 'scopes.activities', 'scopes.activities.pics', 'scopes.activities.progress', 'scopes.activities.progress.evidences'])->where('isActive', 1)->get();

        return view('pages.ganchart.dashboard', compact('projects'));
    }
}
