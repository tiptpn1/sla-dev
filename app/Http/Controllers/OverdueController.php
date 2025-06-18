<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Scope;
use App\Models\Activity;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class OverdueController extends Controller
{
    public function index()
    {
        return view('overdue.index');
    }
    public function getProgressData(Request $request)
    {
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');
        
        $year = $request->input('year', date('Y'));

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

        $rows = [];
        $divisiCounter = 1;

        foreach ($projects as $project) {
            $isFirstRowForProject = true;

            foreach ($project->scopes->where('isActive', true) as $scope) {
                 $isFirstRowForScope = true;
                foreach ($scope->activities->where('isActive', true) as $activity) {
                    if ($activity->plan_start && Carbon::parse($activity->plan_start)->year == $year) {

                        $today = Carbon::today();
                        $planStart = $activity->plan_start ? Carbon::parse($activity->plan_start) : null;
                        $planEnd = $activity->plan_end ? Carbon::parse($activity->plan_end) : null;
                        $actualStart = $activity->actual_start ? Carbon::parse($activity->actual_start) : null;

                        $status = 'Project on Schedule';
                        if ($planStart && $today->gt($planStart) && !$actualStart) {
                            $status = 'Project Overdue Belum Mulai';
                        }
                        elseif ($planEnd && $today->gt($planEnd) && ($average ?? 0 ) < 100) {
                            $status = 'Project Overdue Penyelesaian';
                        }
                        elseif ($planEnd && $today->gte($planEnd->copy()->subDays(7))) {
                            $status = 'Project Akan Overdue';
                        }

                        $rows[] = [
                            'no' => $isFirstRowForProject ? $divisiCounter++ : '',
                            'proyek' => $isFirstRowForProject ? $project->project_nama : '',
                            'scope' => $isFirstRowForScope ? $scope->nama : '',
                            'activity' => $activity->nama_activity,
                            'status' => $status,
                        ];
                        $isFirstRowForProject = false;
                        $isFirstRowForScope = false;
                    }
                }
            }
        }

        return DataTables::of(collect($rows))->make(true);
    }
    public function getChartData(Request $request)
    {
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');
        
        $year = $request->input('year', date('Y'));

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

        $chartCounts = [
            'Project Overdue Penyelesaian' => 0,
            'Project Overdue Belum Mulai' => 0,
            'Project Akan Overdue' => 0,
            'Project on Schedule' => 0
        ];

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    if ($activity->plan_start && Carbon::parse($activity->plan_start)->year == $year) {
                        $average = $activity->progress->avg('persentase');

                        $today = Carbon::today();
                        $planStart = Carbon::parse($activity->plan_start);
                        $planEnd = $activity->plan_end ? Carbon::parse($activity->plan_end) : null;
                        $actualStart = $activity->actual_start ? Carbon::parse($activity->actual_start) : null;

                        $status = 'Project on Schedule';

                        if ($planStart && $today->gt($planStart) && !$actualStart) {
                            $status = 'Project Overdue Belum Mulai';
                        } elseif ($planEnd && $today->gt($planEnd) && ($average ?? 0) < 100) {
                            $status = 'Project Overdue Penyelesaian';
                        } elseif ($planEnd && $today->gte($planEnd->copy()->subDays(7))) {
                            $status = 'Project Akan Overdue';
                        }

                        $chartCounts[$status]++;
                    }
                }
            }
        }
        return response()->json($chartCounts);
    }
} 