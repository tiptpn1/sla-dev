<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScopeRequest;
use App\Http\Requests\UpdateScopeRequest;
use App\Models\Proyek;
use App\Models\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $hakAkses = session()->get('hak_akses_id');
        $subBagianId = session()->get('sub_bagian_id');

        $query = Scope::where('id', $id);

        if ($hakAkses == 9 && $subBagianId) {
            $query->where('sub_bagian_id', $subBagianId);
        }

        $data = $query->first();

        return response()->json($data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaScope' => 'required|string|max:255',
            'namaProyek' => 'required|string|max:255',
            'sub_bagian_id' => 'required|string|max:255',
            'sub_bagian_nama' => 'required|string|max:255',
            'isActive' => 'required|boolean',
        ]);

        Scope::create([
            'nama' => $validated['sub_bagian_nama'],
            'sub_bagian_id' => $validated['sub_bagian_id'],
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
        $hakAkses = session()->get('hak_akses_id');
        $masterBagianId = session()->get('master_bagian_id');

        $query = Proyek::select('id_project', 'project_nama', 'master_nama_bagian_id');

        if ($hakAkses == 10 && $masterBagianId) {
            $query->where('master_nama_bagian_id', $masterBagianId);
        }

        $projects = $query->get();

        return response()->json($projects);
    }

    public function getSubbagianList($master_nama_bagian_id)
    {
        $subBagian = DB::table('master_sub_bagian')
            ->where('master_bagian_id', $master_nama_bagian_id)
            ->get();

        return response()->json($subBagian);
    }

    public function getProcess($id)
    {
        $scope = Scope::with([
            'activities' => function ($query) {
                $query->where('isActive', true);
            },
        ])->findOrFail($id);

        // Hitung rata-rata percent_complete dari semua activities
        $totalPercentComplete = $scope->activities->avg('percent_complete');

        return response()->json(['percent_complete' => $totalPercentComplete]);
    }
}
