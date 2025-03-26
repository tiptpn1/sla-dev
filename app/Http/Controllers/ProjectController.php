<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('pages.data_sla.project');
    }

    // Menyimpan data bagian baru
    public function getData()
    {
        return response()->json(Proyek::all());
    }

    /**
     * Mendapatkan data bagian berdasarkan ID
     *
     * @param int $id ID bagian
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataById($id)
    {
        $data = Proyek::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'master_bagian_nama' => 'required|string|max:255',
            'direktorat_id' => 'max:255',
            'master_bagian_id' => 'required|string|max:255',
            'isActive' => 'required|boolean',
        ]);

        Proyek::create([
            'project_nama' => $validated['master_bagian_nama'],
            'master_bagian_id' => $validated['master_bagian_id'],
            'direktorat_id' => $validated['direktorat_id'],
            'isActive' => $validated['isActive'],
        ]);

        return response()->json(['status' => 'success']);
    }
    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $bagian = Proyek::find($id);
        $bagian->isActive = $validated['status'];
        $bagian->save();

        return response()->json(['status' => 'success']);
    }

    public function updateForm($id, Request $request)
    {
        $validated = $request->validate([
            'namaProyek' => 'string|max:255',
            'status' => 'required|boolean',
        ]);

        $bagian = Proyek::find($id);
        $bagian->project_nama = $validated['namaProyek'];
        $bagian->isActive = $validated['status'];
        $bagian->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        Proyek::destroy($id);
        return response()->json(['status' => 'success']);
    }

    public function getDataDivisi()
    {
        $projects = Bagian::select('master_bagian_id', 'master_bagian_nama', 'direktorat_id')->get();
        return response()->json($projects);
    }
}
