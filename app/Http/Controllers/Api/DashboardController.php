<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
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

        $transformedData = [];

        foreach ($data as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    $transformedData[] = [
                        'project' => $project->project_nama,
                        'scope' => $scope->nama,
                        'activity' => $activity->nama_activity,
                        'plan_start' => $activity->plan_start,
                        'plan_duration' => $activity->plan_duration,
                        'actual_start' => $activity->actual_start,
                        'actual_duration' => $activity->actual_duration,
                        'percent_complete' => round($activity->percent_complete, 2), // Pembulatan ke 2 desimal
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
