<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.master_role.index');
    }

    public function getData()
    {
        return response()->json(HakAkses::where('status', 1)->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $username = DB::table('master_hak_akses')->insert([
                'hak_akses_nama' => $request->name
            ]);
            //dd($username);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $username,
                    'nama' => $request->nama
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
        $bagian = HakAkses::find($id);
        if (!$bagian) {
            return response()->json(['message' => 'Data Master Bagian tidak ditemukan'], 404);
        }
        return response()->json($bagian, 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_hak_akses,hak_akses_id',
            'name' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $role = DB::table('master_hak_akses')
                ->where('hak_akses_id', $request->id)
                ->update([
                    'hak_akses_nama' => $request->name,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $role,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update master hak akses. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            DB::table('master_hak_akses')->where('hak_akses_id', $id)->update(['status' => 0]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Master Bagian deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'success',
                'message' => 'Terjadi kesalahan :' . $e->getMessage(),
            ], 400);
        }
    }
}
