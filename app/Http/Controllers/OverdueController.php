<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Scope;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OverdueController extends Controller
{
    public function index()
    {
        return view('overdue.index');
    }
    public function getProgressData(Request $request)
    {
        $adminAccess   = Session::get('hak_akses_id');
        $bagianId      = Session::get('master_nama_bagian_id');
        $direktoratId  = Session::get('direktorat_id');
        $subDivisiId   = Session::get('id_sub_divisi');
        $year          = $request->input('year', date('Y'));
        $statusFilter  = $request->input('status');
        $status2Filter = $request->input('status2');
        $today         = Carbon::today()->toDateString();

        $query = DB::table('activity')
            ->join('scopes', 'activity.scope_id', '=', 'scopes.id')
            ->join('master_project', 'scopes.project_id', '=', 'master_project.id_project')
            ->select(
                'master_project.project_nama as project',
                'scopes.nama as scope',
                'activity.nama_activity as activity',
                'activity.keterangan',
                'activity.status2',
                'activity.id_activity',
                'activity.plan_start',
                'activity.plan_end',
                'activity.actual_start',
                'activity.percent_complete',
                DB::raw("CASE 
                    WHEN activity.plan_start < '$today' AND activity.actual_start IS NULL THEN 'Project Overdue Belum Mulai Realisasi'
                    WHEN activity.plan_end < '$today' AND activity.percent_complete < 100 THEN 'Project Overdue Penyelesaian'
                    WHEN activity.plan_end >= DATE_SUB('$today', INTERVAL 7 DAY) AND activity.percent_complete < 100 THEN 'Project Akan Overdue'
                    ELSE NULL END as status")
            )
            ->where('activity.isActive', 1)
            ->where('scopes.isActive', 1)
            ->where('master_project.isActive', 1)
            ->where(function ($q) use ($year) {
                $q->whereYear('activity.plan_start', $year)
                ->orWhereYear('activity.plan_end', $year);
            });

        // Filter berdasarkan hak akses 
        if (in_array($adminAccess, [3, 10]) && $bagianId) {
            $query->where('master_project.master_nama_bagian_id', $bagianId);
        } elseif ($adminAccess == 6 && $direktoratId) {
            $query->where('master_project.direktorat_id', $direktoratId);
        } elseif (in_array($adminAccess, [7, 9]) && $subDivisiId) {
            $query->where('scopes.sub_bagian_id', $subDivisiId);
        }

        // Filter status (jika diisi), jika tidak diisi maka default hanya 3 jenis status
        if ($statusFilter) {
            $query->having('status', '=', $statusFilter);
        } else {
            $query->havingRaw("status IN (?, ?, ?)", [
                'Project Overdue Belum Mulai Realisasi',
                'Project Overdue Penyelesaian',
                'Project Akan Overdue'
            ]);
        }

        // Filter status2 
        if ($status2Filter === 'Sudah ditindaklanjuti') {
            $query->where('activity.status2', 1);
        } elseif ($status2Filter === 'Belum ditindaklanjuti') {
            $query->where(function ($q) {
                $q->whereNull('activity.status2')
                ->orWhere('activity.status2', 0);
            });
        }

        // Return dalam format DataTables
        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
    public function getChartData(Request $request)
    {
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');

        $year = $request->input('year', date('Y'));
        $statusFilter = $request->input('status');
        $status2Filter = $request->input('status2');
        $today = Carbon::today()->toDateString();

        // CASE statement untuk menentukan status
        $caseStatus = "CASE 
            WHEN activity.plan_start < '$today' AND activity.actual_start IS NULL THEN 'Project Overdue Belum Mulai Realisasi'
            WHEN activity.plan_end < '$today' AND activity.percent_complete < 100 THEN 'Project Overdue Penyelesaian'
            WHEN activity.plan_end >= DATE_SUB('$today', INTERVAL 7 DAY) AND activity.percent_complete < 100 THEN 'Project Akan Overdue'
            ELSE NULL END";

        $query = DB::table('activity')
            ->join('scopes', 'activity.scope_id', '=', 'scopes.id')
            ->join('master_project', 'scopes.project_id', '=', 'master_project.id_project')
            ->where('activity.isActive', 1)
            ->where('scopes.isActive', 1)
            ->where('master_project.isActive', 1)
            ->where(function ($q) use ($year) {
                $q->whereYear('activity.plan_start', $year)
                ->orWhereYear('activity.plan_end', $year);
            })
            ->selectRaw("$caseStatus as status, COUNT(*) as total")
            ->groupBy('status');

        // Filter hak akses
        if (in_array($adminAccess, [3, 10]) && $bagianId) {
            $query->where('master_project.master_nama_bagian_id', $bagianId);
        } elseif ($adminAccess == 6 && $direktoratId) {
            $query->where('master_project.direktorat_id', $direktoratId);
        } elseif (in_array($adminAccess, [7, 9]) && $subDivisiId) {
            $query->where('scopes.sub_bagian_id', $subDivisiId);
        }

        // Filter status2 
        if ($status2Filter === 'Sudah ditindaklanjuti') {
            $query->where('activity.status2', 1);
        } elseif ($status2Filter === 'Belum ditindaklanjuti') {
            $query->where(function ($q) {
                $q->whereNull('activity.status2')->orWhere('activity.status2', 0);
            });
        } else {
            $query->where(function ($q) {
                $q->whereNull('activity.status2')->orWhere('activity.status2', 0);
            });
        }

        // Filter status jika ada
        if ($statusFilter) {
            $query->having('status', '=', $statusFilter);
        }

        $results = $query->get();

        $chartCounts = [
            'Project Overdue Belum Mulai Realisasi' => 0,
            'Project Overdue Penyelesaian' => 0,
            'Project Akan Overdue' => 0
        ];

        foreach ($results as $row) {
            if ($row->status && isset($chartCounts[$row->status])) {
                $chartCounts[$row->status] = $row->total;
            }
        }

        return response()->json($chartCounts);
    }

    public function getStatus(Request $request)
    {
        $activity = Activity::findOrFail($request->id);
        $activity->status2 = true;
        $activity->save();

        return response()->json(['success' => true]);
    }
    public function updateKeterangan(Request $request)
    {
        $userHakAkses = session('hak_akses_id');
        $isSubdiv = session('id_sub_divisi');

        if ($userHakAkses != 7 && !$isSubdiv) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::table('activity')
            ->where('id_activity', $request->id_activity)
            ->update([$request->field => $request->value]);

        return response()->json([
            'success' => true,
            'message' => 'Keterangan berhasil diperbarui.'
        ]);
    }
    //notifikasi
    public function getCount(Request $request)
    {
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');

        $year = $request->input('year', date('Y'));
        $today = Carbon::today();
        $sevenDays = $today->copy()->addDays(7);

        $query = Proyek::with([
            'scopes' => function ($query) use ($adminAccess, $subDivisiId) {
                $query->where('isActive', 1);
                if (in_array($adminAccess, [7, 9]) && $subDivisiId) {
                    $query->where('sub_bagian_id', $subDivisiId);
                }
            },
            'scopes.activities' => function ($query) use ($year) {
                $query->where('isActive', 1)
                    ->where('status2', 0)
                    ->where(function ($q) use ($year) {
                        $q->whereYear('plan_start', $year)
                            ->orWhereYear('plan_end', $year);
                    });
            }
        ])
        ->where('isActive', true);

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
        $count = 0;

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    if (!$activity->plan_start || !$activity->plan_end) continue;

                    $planStart = Carbon::parse($activity->plan_start);
                    $planEnd = Carbon::parse($activity->plan_end);
                    $actualStart = $activity->actual_start ? Carbon::parse($activity->actual_start) : null;
                    $percent = $activity->percent_complete ?? 0;

                    if ($today->gt($planStart) && !$actualStart) {
                        $count++;
                    } elseif ($today->gt($planEnd) && $percent < 100) {
                        $count++;
                    } elseif ($today->gte($planEnd->copy()->subDays(7)) && $percent < 100) {
                        $count++;
                    }
                }
            }
        }

        return response()->json(['count' => $count]);
    }
} 