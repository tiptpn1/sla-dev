<?php

namespace App\Http\Controllers\ServerSide;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\Scope;
use Illuminate\Http\Request;

class ProjectScopeController extends Controller
{
    public function getProjects()
    {
        $data = Proyek::where('is_active', true)->where('project_nama', 'like', '%' . request('q') . '%')->paginate(10);

        return response()->json([
            'total_data' => $data->total(),
            "incomplete_results" => $data->hasMorePages(),
            'result' => $data->items(),
        ]);
    }

    public function getProjectById($id)
    {
        $data = Proyek::where('id_project', $id)->get();

        return response()->json([
            'data' => $data,
            'message' => 'Success',
        ]);
    }

    public function getScopes($id)
    {
        $data = Scope::where('project_id', $id)->where('isActive', true)->where('nama', 'like', '%' . request('q') . '%')->paginate(10);

        return response()->json([
            'total_data' => $data->total(),
            "incomplete_results" => $data->hasMorePages(),
            'result' => $data->items(),
        ]);
    }

    public function getScopeById($id)
    {
        $data = Proyek::where('id', $id)->get();

        return response()->json([
            'data' => $data,
            'message' => 'Success',
        ]);
    }
}
