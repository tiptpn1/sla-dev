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
        $user = User::with('bagian', 'hakAkses', 'direktorat', 'sub_bagian')->get();
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

            $masterNamaBagianId = null;
            $direktoratId = null;
            $subDivisiId = null;

            $role = DB::table('master_hak_akses')->where('hak_akses_id', $request->role)->first();
            $roleName = strtolower($role->hak_akses_nama);

            if ($roleName === 'direktorat') {
                $direktorat = DB::table('master_direktorat')->where('direktorat_id', $request->divisi)->first();
                $direktoratId = $direktorat->direktorat_id;
            } 
            elseif (in_array($roleName, ['koordinator sub divisi', 'subdivisi'])) {
                $subdivisi = DB::table('master_sub_bagian')->where('id', $request->divisi)->first();
                $subDivisiId = $subdivisi->id;
                $masterNamaBagianId = $subdivisi->master_bagian_id;

                $bagian = DB::table('master_bagian')->where('master_bagian_id', $subdivisi->master_bagian_id)->first();
                if ($bagian) {
                    $direktoratId = $bagian->direktorat_id;
                }
            }
            else {
                $bagian = DB::table('master_bagian')->where('master_bagian_id', $request->divisi)->first();
                if ($bagian) {
                    $masterNamaBagianId = $bagian->master_bagian_id;
                    $direktoratId = $bagian->direktorat_id;
                }
            }

            DB::table('master_user')->insert([
                'master_user_nama' => $request->username,
                'master_user_password' => Hash::make($request->password),
                'master_hak_akses_id' => $request->role,
                'master_nama_bagian_id' => $masterNamaBagianId,
                'direktorat_id' => $direktoratId,
                'id_sub_divisi' => $subDivisiId,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $request->username
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
        $data = User::with('bagian', 'hakAkses', 'direktorat', 'sub_bagian')->find($id);

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:master_user,master_user_id',
            'username' => 'required|string',
            'role' => 'required|exists:master_hak_akses,hak_akses_id',
            'divisi' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $masterNamaBagianId = null;
            $direktoratId = null;
            $subBagianId = null;

            $role = DB::table('master_hak_akses')->where('hak_akses_id', $request->role)->first();
            $roleName = strtolower($role->hak_akses_nama);

            // Set divisi and related IDs based on the role
            if ($roleName === 'direktorat') {
                $direktorat = DB::table('master_direktorat')->where('direktorat_id', $request->divisi)->first();
                $direktoratId = $direktorat->direktorat_id;
            } elseif (in_array($roleName, ['koordinator sub divisi', 'subdivisi'])) {
                $subdivisi = DB::table('master_sub_bagian')->where('id', $request->divisi)->first();
                $subBagianId = $subdivisi->id;
                $masterNamaBagianId = $subdivisi->master_bagian_id;

                $bagian = DB::table('master_bagian')->where('master_bagian_id', $subdivisi->master_bagian_id)->first();
                if ($bagian) {
                    $direktoratId = $bagian->direktorat_id;
                }
            } else {
                $bagian = DB::table('master_bagian')->where('master_bagian_id', $request->divisi)->first();
                if ($bagian) {
                    $masterNamaBagianId = $bagian->master_bagian_id;
                    $direktoratId = $bagian->direktorat_id;
                }            
            }

            $updateData = [
                'master_user_nama' => $request->username,
                'master_hak_akses_id' => $request->role,
                'master_nama_bagian_id' => $masterNamaBagianId,
                'direktorat_id' => $direktoratId,
                'id_sub_divisi' => $subBagianId,
            ];

            DB::table('master_user')->where('master_user_id', $request->id)->update($updateData);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil diperbarui'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui data. Error: ' . $e->getMessage()
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
