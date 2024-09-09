<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BagianController extends Controller
{
    // Menampilkan halaman utama dan data yang ada
    public function index()
    {
        return view('pages.master_bagian.index');
    }

    // Menyimpan data bagian baru
    public function getData()
    {
        return response()->json(Bagian::all());
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
            'isActive' => 'required|boolean',
        ]);

        Bagian::create([
            'master_bagian_nama' => $validated['namaBagian'],
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

    public function delete($id)
    {
        Bagian::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
