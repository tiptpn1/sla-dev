<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\Direktorat;
use App\Models\SubBagian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', true);
            },
            'scopes.activities' => function ($query) {
                $query->where('isActive', true);
            }
        ])->where('isActive', true)->get();

        // Ambil seluruh direktorat dan sub bagian
        $listDirektorat = Direktorat::all();
        $listSubBagian = SubBagian::all();

        $transformedData = [];

        foreach ($data as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {

                    // Default nilai
                    $direktoratNama = null;
                    $subBagianNama = null;

                    // Cek kecocokan pic_id
                    $direktorat = $listDirektorat->firstWhere('id', $activity->pic_id);
                    if ($direktorat) {
                        $direktoratNama = $direktorat->nama;
                    }

                    $subBagian = $listSubBagian->firstWhere('id', $activity->pic_id);
                    if ($subBagian) {
                        $subBagianNama = $subBagian->sub_bagian_nama;
                    }

                    $transformedData[] = [
                        'project' => $project->project_nama,
                        'scope' => $scope->nama,
                        'activity' => $activity->nama_activity,
                        'plan_start' => $activity->plan_start,
                        'plan_duration' => $activity->plan_duration,
                        'actual_start' => $activity->actual_start,
                        'plan_end' => $activity->plan_end,
                        'actual_duration' => $activity->actual_duration,
                        'percent_complete' => round($activity->percent_complete, 2),
                        'direktorat' => $direktoratNama,
                        'sub_divisi' => $subBagianNama,
                    ];
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Success get data dashboard',
            'data' => $transformedData,
        ]);
    }
}
