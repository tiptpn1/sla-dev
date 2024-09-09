<?php

namespace App\Http\Controllers;

use App\Models\Username;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function index()
    {
        return view('pages.master_username.index');
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
            'bagian' => 'required|string',
            'nama' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $bagian = DB::table('kpi_master_bagian')->insert([
                'kpi_master_bagian_nama' => $request->bagian . ' ' . $request->nama,
                'kpi_master_bagian_insert_at' => date('Y-m-d H:i:s'),
                'kpi_master_bagian_update_at' => date('Y-m-d H:i:s'),
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Success',
                'data' => [
                    'id' => $bagian,
                    'nama' => $request->bagian . ' ' . $request->nama
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
        $bagian = DB::table('kpi_master_bagian')->where('kpi_master_bagian_id', $id)->first();

        return response()->json([
            'data' => $bagian
        ], 200);
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:kpi_master_bagian,kpi_master_bagian_id',
            'bagianEdit' => 'required|string',
            'namaEdit' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $bagian = DB::table('kpi_master_bagian')
                ->where('kpi_master_bagian_id', $request->id)
                ->update([
                    'kpi_master_bagian_nama' => $request->bagianEdit . ' ' . $request->namaEdit,
                    'kpi_master_bagian_update_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Success',
                'data' => $bagian
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
            $ids = [$id];

            DB::table('kpi_master_user')->whereIn('kpi_master_nama_bagian_id', $ids)->delete();
            DB::table('kpi_hub_operator')->whereIn('kpi_hub_operator_bagian_id', $ids)->delete();
            DB::table('kpi_hub_pemilik')->whereIn('kpi_hub_pemilik_bagian_id', $ids)->delete();
            DB::table('kpi_distribusi_kpi')->whereIn('kpi_distribusi_kpi_master_bagian_id', $ids)->delete();
            DB::table('kpi_master_bagian')->whereIn('kpi_master_bagian_id', $ids)->delete();

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
