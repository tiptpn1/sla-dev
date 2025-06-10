<?php

namespace App\Http\Controllers\ServerSide;

use App\Models\Scope;
use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProjectScopeController extends Controller
{
    public function getProjects()
    {
        $hakAkses = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $subBagianId = Session::get('sub_bagian_id');

        $query = Proyek::where('isActive', true)->where('project_nama', 'like', '%' . request('q') . '%');

        if (in_array($hakAkses, [9, 10])) {
            $query->where('master_nama_bagian_id', $bagianId);
        }

        if ($subBagianId) {
            $query->whereHas('scopes', function ($q) use ($subBagianId) {
                $q->where('sub_bagian_id', $subBagianId);
            });
        }

        $data = $query->paginate(10);

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
        $subBagianId = session()->get('sub_bagian_id');

        $query = Scope::where('project_id', $id)
            ->where('isActive', true)
            ->where('nama', 'like', '%' . request('q') . '%');

        if ($subBagianId) {
            $query->where('sub_bagian_id', $subBagianId);
        }

        $data = $query->paginate(10);

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
