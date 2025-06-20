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
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subDivisiId = Session::get('id_sub_divisi');
        $year = $request->input('year', date('Y'));
        $today = Carbon::today();
        $sevenDays = $today->copy()->addDays(7);

        $query = DB::table('activity')
            ->join('scopes', 'scopes.id', '=', 'activity.scope_id')
            ->join('master_project', 'master_project.id_project', '=', 'scopes.project_id')
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
                'activity.percent_complete'
            )
            ->where(function ($q) use ($year) {
                $q->whereYear('activity.plan_start', $year)
                ->orWhereYear('activity.plan_end', $year);
            })
            ->where([
                ['activity.isActive', 1],
                ['scopes.isActive', 1],
                ['master_project.isActive', 1],
            ])
            ->whereNotNull('activity.plan_start')
            ->whereNotNull('activity.plan_end');

        // Filter berdasarkan hak akses
        if (in_array($adminAccess, [3, 10]) && $bagianId) {
            $query->where('master_project.master_nama_bagian_id', $bagianId);
        } elseif ($adminAccess == 6 && $direktoratId) {
            $query->where('master_project.direktorat_id', $direktoratId);
        } elseif (in_array($adminAccess, [7, 9]) && $subDivisiId) {
            $query->where('scopes.sub_bagian_id', $subDivisiId);
        }

        // Logika penentuan status overdue
        $query->where(function ($q) use ($today, $sevenDays) {
            $q->where(function ($q1) use ($today) {
                $q1->where('activity.plan_start', '<', $today)
                ->whereNull('activity.actual_start');
            })
            ->orWhere(function ($q2) use ($today) {
                $q2->where('activity.plan_end', '<', $today)
                ->where(function ($q) {
                    $q->where('activity.percent_complete', '<', 100)
                        ->orWhereNull('activity.percent_complete');
                });
            })
            ->orWhere(function ($q3) use ($today, $sevenDays) {
                $q3->whereBetween('activity.plan_end', [$today, $sevenDays])
                ->where(function ($q) {
                    $q->where('activity.percent_complete', '<', 100)
                        ->orWhereNull('activity.percent_complete');
                });
            });
        });

        return DataTables::query($query)
            ->addColumn('status', function ($row) use ($today) {
                $planStart = $row->plan_start ? Carbon::parse($row->plan_start) : null;
                $planEnd = $row->plan_end ? Carbon::parse($row->plan_end) : null;
                $actualStart = $row->actual_start ? Carbon::parse($row->actual_start) : null;
                $percent = $row->percent_complete ?? 0;

                if ($planStart && $today->gt($planStart) && !$actualStart) {
                    return 'Project Overdue Belum Mulai Realisasi';
                } elseif ($planEnd && $today->gt($planEnd) && $percent < 100) {
                    return 'Project Overdue Penyelesaian';
                } elseif ($planEnd && $today->gte($planEnd->copy()->subDays(7)) && $percent < 100) {
                    return 'Project Akan Overdue';
                }
                return '-';
            })
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
            'Project Overdue Belum Mulai Realisasi' => 0,
            'Project Overdue Penyelesaian' => 0,
            'Project Akan Overdue' => 0
        ];

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    if (!$activity->plan_start || !$activity->plan_end) continue;

                    $planStart = Carbon::parse($activity->plan_start);
                    $planEnd = Carbon::parse($activity->plan_end);
                    $actualStart = $activity->actual_start ? Carbon::parse($activity->actual_start) : null;
                    $percent = $activity->percent_complete ?? 0;

                    if ($planStart && $today->gt($planStart) && !$actualStart) {
                        $chartCounts['Project Overdue Belum Mulai Realisasi']++;
                    } elseif ($planEnd && $today->gt($planEnd) && $percent < 100) {
                        $chartCounts['Project Overdue Penyelesaian']++;
                    } elseif ($planEnd && $today->gte($planEnd->copy()->subDays(7)) && $percent < 100) {
                        $chartCounts['Project Akan Overdue']++;
                    }
                }
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