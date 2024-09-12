<?php

namespace App\Http\Controllers\ServerSide;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function data(Request $request)
    {
        $activities = Activity::with(['pics', 'proyek'])->select(['id_activity', 'nama_activity', 'plan_start', 'plan_duration', 'actual_start', 'actual_duration', 'percent_complete', 'project_id'])->get();

        // if ($request->ajax()) {
        return DataTables::of($activities)
            ->addIndexColumn()
            ->editColumn('percent_complete', function ($row) {
                return number_format($row->percent_complete, 1) . '%'; // Format persentase
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('activities.edit', $row->id_activity) . '" class="btn btn-primary btn-sm">Edit</a>';

                $deleteBtn = '<a href="javascript:void(0)" onclick="deleteActivity(' . $row->id_activity . ')" class="btn btn-danger btn-sm">Delete</a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action']) // Menandai kolom aksi agar HTML bisa dirender
            ->make(true);
        // }

        // return response()->json([
        //     'data' => $activities,
        // ]);
    }
}
