<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsernameController extends Controller
{
    public function index()
    {
        $all_divisi = DB::table('master_bagian')->select('*')->get();
        $hak_akses = DB::table('master_hak_akses')->select('*')->where('status', '!=', 0)->get();
        return view('pages.master_username.index', compact('all_divisi', 'hak_akses'));
    }

    public function getData()
    {
        $user = User::with('bagian', 'hakAkses')->get();
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string',
            'divisi' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Ambil direktorat_id dan id_sub_divisi dari master_bagian
            $bagian = DB::table('master_bagian')->where('master_bagian_id', $request->divisi)->first();

            if (!$bagian) {
                return response()->json([
                    'message' => 'Divisi tidak ditemukan.'
                ], 404);
            }

            $username = DB::table('master_user')->insert([
                'master_user_nama' => $request->username,
                'master_nama_bagian_id' => $request->divisi,
                'master_user_password' => Hash::make($request->password),
                'master_hak_akses_id' => $request->role,
                'direktorat_id' => $bagian->direktorat_id,
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
        $data = User::with('bagian', 'hakAkses')->find($id);

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_user,master_user_id',
            'username' => 'required|string',
            'role' => 'required|exists:master_hak_akses,hak_akses_id',
            'divisi' => 'required|exists:master_bagian,master_bagian_id',
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
                    'master_user_nama' => $request->username,
                    'master_nama_bagian_id' => $request->divisi,
                    'master_hak_akses_id' => $request->role,
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
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

            User::destroy($id);

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
