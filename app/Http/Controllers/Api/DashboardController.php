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
                // Ambil semua activities yang aktif pada scope ini
                $activities = $scope->activities;

                // Hitung rata-rata percent_complete untuk activities di scope ini
                $totalPercentage = $activities->sum('percent_complete');
                $activityCount = $activities->count();
                $averagePercentage = $activityCount > 0 ? $totalPercentage / $activityCount : 0;

                // Tambahkan data ke hasil transformasi
                $transformedData[] = [
                    'project' => $project->project_nama,
                    'scope' => $scope->nama,
                    'persentase' => round($averagePercentage, 2), // Pembulatan ke 2 desimal
                ];
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Success get data dashboard',
            'data' => $transformedData,
        ]);
    }
}
