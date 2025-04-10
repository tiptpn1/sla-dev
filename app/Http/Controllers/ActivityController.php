<?php

namespace App\Http\Controllers;

use App\Models\Pic;
use App\Models\Bagian;
use App\Models\Proyek;
use App\Models\Activity;
use App\Models\SubBagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminAccess = Session::get('hak_akses_id');
        $masterBagianId = Session::get('bagian_id');
        $direktoratId = Session::get('direktorat_id');
        $subBagianId = Session::get('sub_bagian_id');

        // Mulai query builder untuk proyek
        $query = Proyek::with([
            'scopes' => function ($query) use ($adminAccess, $subBagianId) {
                $query->where('isActive', 1);

                // Filter scopes untuk level 7, hanya yang memiliki aktivitas di mana user adalah PIC
                if ($adminAccess == 7 && $subBagianId) {
                    $query->whereHas('activities.pics', function ($q) use ($subBagianId) {
                        $q->where('sub_bagian_id', $subBagianId);
                    });
                }
            },
            'scopes.activities' => function ($query) use ($adminAccess, $subBagianId) {
                if ($adminAccess != 2) {
                    $query->where('isActive', 1);
                }

                // Filter aktivitas untuk level 7
                if ($adminAccess == 7 && $subBagianId) {
                    $query->whereHas('pics', function ($q) use ($subBagianId) {
                        $q->where('sub_bagian_id', $subBagianId);
                    });
                }
            },
            'scopes.activities.pics',
            'scopes.activities.pics.subBagian',
            'scopes.activities.progress' => function ($query) {
                $query->latest('tanggal')->get();
            },
            'scopes.activities.progress.evidences' => function ($query) {
                $query->latest('created_at')->get();
            }
        ])->where('isActive', true);

        // Jika user adalah level divisi (hak_akses_id = 3)
        if (in_array($adminAccess, [3, 7]) && $masterBagianId) {
            $query->where('master_bagian_id', $masterBagianId);
        }


        // Jika user adalah level direktorat (hak_akses_id = 6)
        if ($adminAccess == 6 && $direktoratId) {
            $query->where('direktorat_id', $direktoratId);
        }

        // Filter proyek di level paling atas untuk level 7
        if ($adminAccess == 7 && $subBagianId) {
            $query->whereHas('scopes.activities.pics', function ($q) use ($subBagianId) {
                $q->where('sub_bagian_id', $subBagianId);
            });
        }

        // Eksekusi query dan dapatkan hasilnya
        $projects = $query->get();

        return view('activities.index', compact('projects'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Proyek::select('id_project', 'project_nama')->get();
        $bagians = Bagian::select('master_bagian_id', 'master_bagian_nama')->get();
        $subBagians = SubBagian::select('id', 'sub_bagian_nama')->get();

        $bagianId = Session::get('bagian_id');

        return view('activities.create', compact('projects', 'bagians', 'subBagians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'nama_activity' => 'required|string|max:255',
            'plan_start' => 'nullable|date',
            'plan_duration' => 'nullable|integer',
            'actual_start' => 'nullable|date',
            'actual_duration' => 'nullable|integer',
            'percent_complete' => 'nullable|integer|min:0|max:100',
            'project_id' => 'required|exists:master_project,id_project',
            'scope_id' => 'required|exists:scopes,id',
            'bagian_id' => 'required|array',
            'bagian_id.*' => 'exists:master_bagian,master_bagian_id',
        ]);

        // dd($request->all());

        // Menyimpan data activity ke dalam database
        $activity = Activity::create([
            'nama_activity' => $request->nama_activity,
            'plan_start' => $request->plan_start,
            'plan_duration' => $request->plan_duration,
            'actual_start' => $request->actual_start,
            'actual_duration' => $request->actual_duration,
            'percent_complete' => $request->percent_complete,
            'scope_id' => $request->scope_id,
            'project_id' => $request->project_id,
            'isActive' => true,
        ]);

        // Menyimpan data pic ke dalam database
        foreach ($request->bagian_id as $bagianId) {
            Pic::create([
                'activity_id' => $activity->id_activity,
                'sub_bagian_id' => $bagianId,
            ]);
        }
        session()->flash('success', 'Activity insert successfully!');

        return redirect()->route('activities.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::where('id_activity', $id)->with(['pics'])->first();

        $bagianId = Session::get('bagian_id');

        $hasAccess = $activity->pics->contains(function ($pic) use ($bagianId) {
            return $pic->bagian_id == $bagianId;
        });

        $bagians = Bagian::all();
        return view('activities.edit', compact('activity', 'bagians', 'hasAccess'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_activity' => 'required|string|max:255',
            'plan_start' => 'nullable|date',
            'plan_duration' => 'nullable|integer',
            'actual_start' => 'nullable|date',
            'actual_duration' => 'nullable|integer',
            'percent_complete' => 'nullable|integer|min:0|max:100',
            'project_id' => 'required|exists:master_project,id_project',
            'scope_id' => 'required|exists:scopes,id',
            'bagian_id' => 'required|array',
            'bagian_id.*' => 'exists:master_bagian,master_bagian_id',
        ]);

        $activity = Activity::findOrFail($id);

        $activity->update([
            'nama_activity' => $request->nama_activity,
            'plan_start' => $request->plan_start,
            'plan_duration' => $request->plan_duration,
            'actual_start' => $request->actual_start,
            'actual_duration' => $request->actual_duration,
            'percent_complete' => $request->percent_complete,
            'project_id' => $request->project_id,
            'scope_id' => $request->scope_id,
        ]);

        $activity->pics()->delete();

        foreach ($request->bagian_id as $bagianId) {
            Pic::create([
                'activity_id' => $activity->id_activity,
                'master_bagian_id' => $bagianId,
            ]);
        }
        session()->flash('success', 'Activity updated successfully!');
        return redirect()->route('activities.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->pics()->delete(); // Hapus relasi terlebih dahulu jika diperlukan
            $activity->delete(); // Hapus activity

            return response()->json(['success' => 'Activity deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete activity'], 500);
        }
    }

    public function updateActivity(Request $request)
    {
        $id = $request->input('id');
        $field = $request->input('field');
        $value = $request->input('value');

        if (in_array($field, [
            'plan_start',
            'plan_duration',
            'plan_end',
            'actual_start',
            'actual_duration',
            'actual_end',
            'percent_complete'
        ])) {

            // Update field yang diminta
            $update = Activity::where('id_activity', $id)->update([$field => $value]);

            if ($update) {
                $activity = Activity::where('id_activity', $id)->first();

                if ($activity->plan_start && $activity->plan_duration) {
                    // Ambil plan_start sebagai tanggal dan duration sebagai minggu
                    $planStart = \Carbon\Carbon::parse($activity->plan_start);
                    $planDurationWeeks = intval($activity->plan_duration);

                    // Hitung tanggal akhir (plan_end) berdasarkan jumlah minggu
                    $planEnd = $planStart->copy()->addWeeks($planDurationWeeks - 1);

                    $activity->plan_end = $planEnd->format('Y-m-d');
                    $activity->save();
                }

                if ($activity->actual_start && $activity->actual_duration) {
                    // Ambil actual_start sebagai tanggal dan duration sebagai minggu
                    $actualStart = \Carbon\Carbon::parse($activity->actual_start);
                    $actualDurationWeeks = intval($activity->actual_duration);

                    // Hitung tanggal akhir (actual_end) berdasarkan jumlah minggu
                    $actualEnd = $actualStart->copy()->addWeeks($actualDurationWeeks - 1);

                    $activity->actual_end = $actualEnd->format('Y-m-d');
                    $activity->save();
                }


                // Return hasil update
                return response()->json([
                    'message' => 'Activity updated successfully',
                    'data' => Activity::where('id_activity', $id)->first(),
                ]);
            } else {
                return response()->json(['message' => 'Failed to update activity'], 500);
            }
        }

        return response()->json(['message' => 'Invalid field'], 400);
    }




    public function updateStatus(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->isActive = $request->input('status');
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity status updated successfully',
        ]);
    }
}
