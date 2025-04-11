<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirektoratController extends Controller
{
    
    public function index()
    {
        return view('pages.master_direktorat.index');
    }

    // Menyimpan data direktorat baru
    public function getData()
    {
        return response()->json(Direktorat::all());
    }

    /**
     * Mendapatkan data direktorat berdasarkan ID
     *
     * @param int $id ID direktorat
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataById($id)
    {
        $data = Direktorat::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Direktorat::create([
            'nama' => $validated['nama'],
            'status' => $validated['status'],
        ]);

        return response()->json(['status' => 'success']);
    }
    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $direktorat = Direktorat::find($id);
        $direktorat->status = $validated['status'];
        $direktorat->save();

        return response()->json(['status' => 'success']);
    }

    public function updateForm($id, Request $request)
    {
        $validated = $request->validate([
            'nama' => 'string|max:255',
            'status' => 'required|boolean',
        ]);

        $direktorat = Direktorat::find($id);
        if ($validated['nama']) {
            $direktorat->nama = $validated['nama'];
        }
        $direktorat->nama = $validated['nama'];
        $direktorat->status = $validated['status'];
        $direktorat->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        $direktorat = Direktorat::where('direktorat_id', $id)->first();
        $direktorat->delete(); 
        return response()->json(['status' => 'success']);
    }

}
