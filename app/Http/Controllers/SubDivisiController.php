<?php

namespace App\Http\Controllers;

use App\Models\SubDivisi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubDivisiController extends Controller
{
    public function index()
    {
        $all_divisi = DB::table('master_bagian')->select('*')->get();
        $direktorat = DB::table('master_direktorat')->select('*')->where('status', '!=', 0)->get();
        return view('pages.master_sub_divisi.index', compact('all_divisi', 'direktorat'));
    }
    public function getData()
    {
        $subDivisi = SubDivisi::with('bagian', 'direktorat')->get();
        return response()->json($subDivisi);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required|string',
            'kode' => 'required|string',
            'divisi' => 'required|string',
            'direktorat' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $subdivisi = DB::table('master_sub_bagian')->insert([
                'sub_bagian_nama' => $request->nama,
                'sub_bagian_kode' => $request->kode,
                'master_bagian_id' => $request->divisi,
                'direktorat_id' => $request->direktorat,
                'status' => $request->status,
            ]);
            //dd($subdivisi);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $subdivisi,
                    'nama' => $request->subdivisi
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataById($id)
    {
        $data = SubDivisi::with('bagian', 'direktorat')->find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_sub_bagian,id',
            'nama' => 'required|string',
            'kode' => 'required|string',
            'divisi' => 'required|exists:master_bagian,master_bagian_id',
            'direktorat' => 'required|exists:master_direktorat,direktorat_id',
            'status' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $subdivisi = DB::table('master_sub_bagian')
                ->where('id', $id)
                ->update([
                    'sub_bagian_nama' => $request->nama,
                    'sub_bagian_kode' => $request->kode,
                    'master_bagian_id' => $request->divisi,
                    'direktorat_id' => $request->direktorat,
                    'status' => $request->status,
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $subdivisi
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update master bagian. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $subdivisi = SubDivisi::find($id);
        $subdivisi->status = $validated['status'];
        $subdivisi->save();

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Pastikan $id diubah menjadi array
            // $ids = [$id];

            SubDivisi::destroy($id);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Master Bagian deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan :' . $e->getMessage(),
            ], 400);
        }
    }
}
