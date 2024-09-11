<?php

namespace App\Http\Controllers;

use App\Models\Scope;
use App\Models\Proyek;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreScopeRequest;
use App\Http\Requests\UpdateScopeRequest;

class ScopeController extends Controller
{
    public function index()
    {
        return view('pages.data_sla.scope');
    }

    // Menyimpan data scope baru
    public function getData()
    {
        $scopes = DB::table('scopes')
            ->join('master_project', 'scopes.project_id', '=', 'master_project.id_project')
            ->select('scopes.*', 'master_project.project_nama') // Menentukan kolom yang ingin diambil
            ->get();

        return response()->json($scopes);
    }


    /**
     * Mendapatkan data scope berdasarkan ID
     *
     * @param int $id ID scope
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataById($id)
    {
        $data = Scope::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaScope' => 'required|string|max:255',
            'namaProyek' => 'required|string|max:255',
            'isActive' => 'required|boolean',
        ]);

        Scope::create([
            'nama' => $validated['namaScope'],
            'project_id' => $validated['namaProyek'],
            'isActive' => $validated['isActive'],
        ]);

        return response()->json(['status' => 'success']);
    }
    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $scope = Scope::find($id);
        $scope->isActive = $validated['status'];
        $scope->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Mengupdate data scope
     *
     * @param int $id ID scope yang ingin diupdate
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateForm($id, Request $request)
    {
        $validated = $request->validate([
            'namaScope' => 'string|max:255',
            'namaProyek' => 'string|max:255',
            'status' => 'required|boolean',
        ]);

        $scope = Scope::find($id);
        $scope->nama = $validated['namaScope'];
        $scope->project_id = $validated['namaProyek'];
        $scope->isActive = $validated['status'];
        $scope->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        Scope::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function getProjectList()
    {
        $projects = Proyek::select('id_project', 'project_nama')->get();
        return response()->json($projects);
    }
}
