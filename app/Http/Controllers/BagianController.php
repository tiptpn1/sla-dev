<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Direktorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BagianController extends Controller
{
    // Menampilkan halaman utama dan data yang ada
    public function index()
    {
        $direktorat = DB::table('master_direktorat')->select('*')->where('status', '!=', 0)->get();
        return view('pages.master_bagian.index', compact('direktorat'));
    }

    // Menyimpan data bagian baru
    public function getData()
    {
        $bagian = Bagian::with('direktorat')->get();
        return response()->json($bagian);
    }

    /**
     * Mendapatkan data bagian berdasarkan ID
     *
     * @param int $id ID bagian
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataById($id)
    {
        $data = Bagian::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaBagian' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'direktorat' => 'required|integer|exists:master_direktorat,direktorat_id',
            'isActive' => 'required|boolean',
        ]);

        Bagian::create([
            'master_bagian_nama' => $validated['namaBagian'],
            'master_bagian_kode' => $validated['kode'], 
            'direktorat_id' => $validated['direktorat'],
            'is_active' => $validated['isActive'],
        ]);

        return response()->json(['status' => 'success']);
    }
    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $bagian = Bagian::find($id);
        $bagian->is_active = $validated['status'];
        $bagian->save();

        return response()->json(['status' => 'success']);
    }

    public function updateForm($id, Request $request)
    {
        $validated = $request->validate([
            'bagian' => 'string|max:255',
            'kode' => 'required|string|max:50',
            'direktorat' => 'required|integer|exists:master_direktorat,direktorat_id',
            'status' => 'required|boolean',
        ]);

        $bagian = Bagian::find($id);
        $bagian->master_bagian_nama = $validated['bagian'];
        $bagian->master_bagian_kode = $validated['kode'];
        $bagian->direktorat_id = $validated['direktorat'];
        $bagian->is_active = $validated['status'];
        $bagian->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        Bagian::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
