<?php

namespace App\Http\Controllers;

use App\Models\Username;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function index()
    {
        $all_divisi = DB::table('master_bagian')->select('*')->get();
        $hak_akses = DB::table('master_hak_akses')->select('*')->where('status', '!=', 0)->get();
        return view('pages.master_username.index', compact('all_divisi', 'hak_akses'));
    }

    public function getData(Request $request)
    {
        $currentPage = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $username = DB::table('master_user as username')
        ->leftJoin('master_bagian as bagian', 'username.master_nama_bagian_id', '=', 'bagian.master_bagian_id')
        ->leftJoin('master_hak_akses as role', 'username.master_hak_akses_id', '=', 'role.hak_akses_id')
        ->select('username.*', 'bagian.master_bagian_nama','role.hak_akses_nama') // Memilih kolom dari master_user dan master_bagian
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => $username->items(),
            'pagination' => [
                'current_page' => $username->currentPage(),
                'last_page' => $username->lastPage(),
                'total' => $username->total(),
                'per_page' => $username->perPage()
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required|string',
            'pass' => 'required|string',
            'divisi' => 'required|string',
            'role' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $username = DB::table('master_user')->insert([
                'master_user_nama' => $request->nama,
                'master_nama_bagian_id' => $request->divisi,
                'master_user_password' => Hash::make($request->pass),
                'master_hak_akses_id' => $request->role
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
        $bagian = DB::table('master_user')->where('master_user_id', $id)->first();

        return response()->json([
            'data' => $bagian
        ], 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_user,master_user_id',
            'nama' => 'required|string',
            'divisi' => 'required',
            'role' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $user = DB::table('master_user')
                ->where('master_user_id', $request->id)
                ->update([
                    'master_user_nama' => $request->nama,
                    'master_nama_bagian_id' => $request->divisi,
                    'master_hak_akses_id' => $request->role,
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Success',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update master bagian. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Pastikan $id diubah menjadi array
            // $ids = [$id];

            DB::table('master_user')->where('master_user_id', $id)->delete();

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
