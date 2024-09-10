<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.master_role.index');
    }

    public function getData(Request $request)
    {
        $currentPage = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $role = DB::table('master_hak_akses as role')
        ->select('role.*') // Memilih kolom dari master_user dan master_bagian
        ->where('status', '!=', 0)
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => $role->items(),
            'pagination' => [
                'current_page' => $role->currentPage(),
                'last_page' => $role->lastPage(),
                'total' => $role->total(),
                'per_page' => $role->perPage()
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'role' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $username = DB::table('master_hak_akses')->insert([
                'hak_akses_nama' => $request->role
            ]);
            //dd($username);
            DB::commit();

            return response()->json([
                'message' => 'Success',
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
        $bagian = DB::table('master_hak_akses')->where('hak_akses_id', $id)->first();

        return response()->json([
            'data' => $bagian
        ], 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_hak_akses,hak_akses_id',
            'namaEdit' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $role = DB::table('master_hak_akses')
                ->where('hak_akses_id',$request->id)
                ->update([
                    'hak_akses_nama'=> $request->namaEdit,
                    'updated_at'=> now(),
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Success',
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
            DB::table('master_hak_akses')->where('hak_akses_id',$id)->update(['status' => 0]);

            DB::commit();

            return response()->json([
                'success' => true,
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
