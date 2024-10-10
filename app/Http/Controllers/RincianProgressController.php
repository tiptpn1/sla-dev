<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Evidence;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RincianProgressController extends Controller
{
    public function index($id)
    {
        $activity = Activity::where('isActive', true)->where('id_activity', $id)->with(['scope', 'scope.project', 'pics'])->first();

        if (!$activity) {
            return redirect()->back()->with('error', 'Activity not found');
        }

        $bagianId = Session::get('bagian_id');

        $hasAccess = $activity->pics->contains(function ($pic) use ($bagianId) {
            return $pic->bagian_id == $bagianId;
        });

        return view('pages.rincian_progress.index', [
            'id' => $id,
            'activity' => $activity,
            'hasAccess' => $hasAccess
        ]);
    }

    public function getData(Request $request)
    {
        // $currentPage = $request->input('page', 1);
        // $perPage = $request->input('per_page', 5);

        $rincianProgress = DB::table('detail_progress as dp')
            // ->leftJoin('evidence as e', 'dp.id', '=', 'e.progress_id')
            // ->select('dp.*', DB::raw('GROUP_CONCAT(e.`file_path` SEPARATOR \', \') as bukti')) // Memilih kolom dari master_user dan master_bagian
            ->select('dp.*') // Memilih kolom dari master_user dan master_bagian
            ->where('activity_id', '=', $request->activity_id)
            ->where('isActive', 1)
            ->orderBy('tanggal', 'asc')
            // ->groupBy('dp.id')
            // ->paginate($perPage, ['*'], 'page', $currentPage);
            ->get();

        return response()->json([
            // 'data' => $rincianProgress->items(),
            'data' => $rincianProgress,
            // 'pagination' => [
            //     'current_page' => $rincianProgress->currentPage(),
            //     'last_page' => $rincianProgress->lastPage(),
            //     'total' => $rincianProgress->total(),
            //     'per_page' => $rincianProgress->perPage()
            // ],
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'activity_id' => 'required|exists:activity,id_activity',
            'rincian_progress' => 'required|string',
            'tindak_lanjut' => 'required|string',
            'file_evidence' => 'nullable|mimes:pdf,jpg,zip,rar,xlsx,xls|max:10240',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();

            // $rincian_progress = DB::table('detail_progress')->insert([
            //     'activity_id' => $request->activity_id,
            //     'rincian_progress' => $request->rincian_progress,
            //     'kendala' => $request->kendala,
            //     'tindak_lanjut' => $request->tindak_lanjut,
            // ]);

            $detail_progress = new Progress();
            $detail_progress->activity_id = $request->activity_id;
            $detail_progress->rincian_progress = $request->rincian_progress;
            $detail_progress->kendala = $request->kendala;
            $detail_progress->tindak_lanjut = $request->tindak_lanjut;
            $data = $detail_progress->save();

            $file_evidence = $request->file('file_evidence');
            if ($file_evidence) {
                $filename = time() . '_' . $file_evidence->getClientOriginalName();
                $file_evidence->move(public_path() . '/evidence', $filename);
                $file_path = 'evidence/' . $filename;

                DB::table('evidence')->insert([
                    'progress_id' => $detail_progress->id,
                    'filename' => $filename,
                    'file_path' => $file_path,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required|exists:detail_progress,id',
            'rincian_progress' => 'required|string',
            'tindak_lanjut' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => $validatedData->errors()->first(),
            ], 400);
        }

        try {
            DB::beginTransaction();

            $data = DB::table('detail_progress')->where('id', $request->id)->update([
                'rincian_progress' => $request->rincian_progress,
                'kendala' => $request->kendala,
                'tindak_lanjut' => $request->tindak_lanjut,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            DB::table('detail_progress')->where('id', $id)->update([
                'isActive' => 0,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil menghapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function getDataEvidence(Request $request)
    {
        // $currentPage = $request->input('page', 1);
        // $perPage = $request->input('per_page', 5);

        $rincianProgress = DB::table('evidence')
            ->select('*') // Memilih kolom dari master_user dan master_bagian
            ->where('progress_id', '=', $request->rincian_progress_id)
            // ->paginate($perPage, ['*'], 'page', $currentPage);
            ->get();

        return response()->json([
            // 'data' => $rincianProgress->items(),
            'data' => $rincianProgress,
            // 'pagination' => [
            //     'current_page' => $rincianProgress->currentPage(),
            //     'last_page' => $rincianProgress->lastPage(),
            //     'total' => $rincianProgress->total(),
            //     'per_page' => $rincianProgress->perPage()
            // ],
        ], 200);
    }

    public function uploadDataEvidence(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'file_evidence' => 'nullable|mimes:pdf,jpg,zip,rar,xlsx,xls|max:10240',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validatedData->errors()->first(),
                ], 400);
            }

            $file_evidence = $request->file('file_evidence');
            $filename = time() . '_' . $file_evidence->getClientOriginalName();
            $file_evidence->move(public_path() . '/evidence', $filename);
            $file_path = 'evidence/' . $filename;

            DB::table('evidence')->insert([
                'progress_id' => $request->progress_id,
                'filename' => $filename,
                'file_path' => $file_path,
            ]);

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function updateDataEvidence(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'id_evidence' => 'required',
                'file_evidence' => 'nullable|mimes:pdf,jpg,zip,rar,xlsx,xls|max:10240',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validatedData->errors()->first(),
                ], 400);
            }

            $evidence = Evidence::where('id_evidence', $request->id_evidence)->first();

            if (!$evidence) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'failed to update evidence',
                ], 400);
            }

            unlink($evidence->file_path);

            $file = $request->file('file_evidence');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path() . '/evidence', $filename);

            $path = 'evidence/' . $filename;

            $evidence->update([
                'filename' => $filename,
                'file_path' => $path,
            ]);

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function deleteEvidence(Request $request)
    {
        try {
            DB::beginTransaction();

            $evidence = Evidence::where('id_evidence', $request->id_evidence)->first();

            if (!$evidence) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete evidence',
                ], 400);
            }

            $path = $evidence->file_path;

            $evidence->delete();

            if ($path) {
                unlink(public_path($path));
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }

    public function downloadEvidence(Request $request)
    {
        try {
            $evidence = DB::table('evidence')->where('id_evidence', $request->id_evidence)->select('*')->get();

            if ($evidence) {
                if (!$evidence[0]->file_path) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'failed to download file',
                    ], 400);
                }

                $file_path = public_path($evidence[0]->file_path);

                return response()->download($file_path);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'failed to download file',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 400);
        }
    }
}
