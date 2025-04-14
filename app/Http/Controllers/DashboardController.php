<?php

namespace App\Http\Controllers;

use App\Exports\ProgressDataExport;
use App\Models\Activity;
use App\Models\Bagian;
use App\Models\Eviden;
use App\Models\Proyek;
use App\Traits\RoleTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;
use ZipArchive;

class DashboardController extends Controller
{
    public function index()
    {   
        // dd(session()->all());
        $direktoratId = Session::get('direktorat_id');
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id'); 
        $subDivisiId = Session::get('id_sub_divisi'); 
        $scopeProjectId = Session::get('sub_bagian_id');

        if ($adminAccess == 6) {
            $projects = Proyek::where('isActive', true)
                            ->where('direktorat_id', $direktoratId)
                            ->with(['scopes' => function($query) {
                                $query->where('isActive', true);
                            }]) 
                            ->select('id_project', 'project_nama')                  
                            ->get();
        } 
        elseif ($adminAccess == 7 && $adminAccess == 9 && $subDivisiId) {
            $projects = Proyek::where('isActive', true)
                ->whereHas('scopes', function ($query) use ($subDivisiId) {
                    $query->where('isActive', true)
                          ->where('sub_bagian_id', $subDivisiId);
                })
                ->with(['scopes' => function ($query) use ($subDivisiId) {
                    $query->where('isActive', true)
                          ->where('sub_bagian_id', $subDivisiId);
                }])
                ->select('id_project', 'project_nama')
                ->get();
        }

        elseif ($adminAccess == 3 && $adminAccess == 10 && $bagianId) {
            $projects = Proyek::where('isActive', true)
                            ->where('master_nama_bagian_id', $bagianId)
                            ->select('id_project', 'project_nama')
                            ->get();
        }
        else {
            $projects = Proyek::where('isActive', true)
                            ->select('id_project', 'project_nama')
                            ->get();
        }

        $progressColors = ['bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary'];
        // dd($projects);
        return view('dashboard.index', compact('projects', 'progressColors'));
    }

    public function activity()
    {
        $adminAccess = Session::get('hak_akses_id');
        $bagianId = Session::get('master_nama_bagian_id');
        $direktoratId = Session::get('direktorat_id');

        // Mulai query builder untuk proyek
        $query = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities' => function ($query) use ($adminAccess) {
                if ($adminAccess != 2) {
                    $query->where('isActive', 1);
                }
            },
            'scopes.activities.pics',
            'scopes.activities.pics.bagian',
            'scopes.activities.progress' => function ($query) {
                $query->latest('tanggal')->get();
            },
            'scopes.activities.progress.evidences' => function ($query) {
                $query->latest('created_at')->get();
            }
        ])->where('isActive', true);

        // Jika user adalah level divisi (hak_akses_id = 3), 
        // filter proyek berdasarkan master_nama_bagian_id
        if ($adminAccess == 3 && $bagianId) {
            $query->where('master_nama_bagian_id', $bagianId);
        }

        if ($adminAccess == 6 && $bagianId) {
            $query->where('direktorat_id', $direktoratId);
        }

        // Eksekusi query dan dapatkan hasilnya
        $projects = $query->get();

        return view('activities.index', compact('projects'));
    }

    public function downloadPdf(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $projectId = $request->get('project', 0);

        // Ambil proyek berdasarkan ID dan tahun yang dipilih
        $projects = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities.pics',
            'scopes.activities.pics.bagian',
            'scopes.activities.progress' => function ($query) {
                $query->latest('created_at'); // Mengambil progress terbaru
            },
        ])->where('isActive', 1)
            ->where(function ($query) use ($projectId) {
                if ($projectId != 0) {
                    $query->where('id_project', $projectId);
                }
            })
            ->whereYear('created_at', $year)
            ->get();

        // Jika proyek tidak ditemukan, kembalikan error 404
        // if (!$project) {
        //     return response()->json(['error' => 'Proyek tidak ditemukan.'], 404);
        // }

        $months = [];
        $countWeeks = 0;

        // Loop untuk setiap bulan dalam tahun ini
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            // Menghitung jumlah minggu dalam bulan
            $weeks = $this->countWeeksInMonth($startDate, $endDate);
            $countWeeks += $weeks;
            $months[$month] = [
                'month' => $startDate->format('F'),
                'weeks' => $weeks,
            ];
        }

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    $planStart = Carbon::parse($activity->plan_start);
                    $planDuraton = $activity->plan_duration;
                    $actualStart = Carbon::parse($activity->actual_start);
                    $actualDuraton = $activity->actual_duration;

                    // dd($activity, $actualStart);
                    $planWeekStart = 0;
                    $planWeekEnd = 0;
                    $countWeekPlan = 0;
                    if ($planStart->format('Y') == $year) {
                        foreach ($months as $key => $month) {
                            if ($month['month'] == $planStart->format('F')) {
                                $planWeekStart = $this->StartWeeks($planStart, $countWeekPlan);
                                $plan_duration = $planDuraton - 1;
                                $start_date_raw = $planStart->copy();
                                $end_plan = $start_date_raw->modify("+{$plan_duration} weeks");
                                $planWeekEnd = $this->EndWeek($end_plan, $countWeekPlan);
                            } else {
                                $countWeekPlan += $month['weeks'];
                            }
                        }
                    }

                    $ActualWeekStart = 0;
                    $actualWeekEnd = 0;
                    $countWeekActual = 0;
                    if ($actualStart->format('Y') == $year) {
                        foreach ($months as $key => $month) {
                            if ($month['month'] == $actualStart->format('F')) {
                                $ActualWeekStart = $this->StartWeeks($actualStart, $countWeekActual);
                                $actual_duration = $actualDuraton - 1;
                                $actual_date_raw = $actualStart->copy();
                                $end_actual = $actual_date_raw->modify("+{$actual_duration} weeks");
                                // dd($end_plan);
                                $actualWeekEnd = $this->EndWeek($end_actual, $countWeekActual);
                            } else {
                                $countWeekActual += $month['weeks'];
                            }
                        }
                    }
                    $activity->plan_week_start = $planWeekStart;
                    $activity->plan_week_end = $planWeekEnd;
                    $activity->actual_week_start = $ActualWeekStart;
                    $activity->actual_week_end = $actualWeekEnd;
                    // dd($planWeekStart, $planWeekEnd, $ActualWeekStart, $ActualWeekEnd);
                    // $startWeekPlan = 1;
                    // $startWeekActual = 2;
                    // dd($planStart, $actualStart);
                }
            }
        }

        // Mengembalikan hasil sebagai respons JSON
        // return response()->json([
        //     'year' => $year,
        //     'months' => $months,
        //     'countWeeks' => $countWeeks,
        //     'projects' => $projects,
        // ]);


        $pdf = Pdf::loadView('pdf.dashboard-sla', [
            'project' => $project,
            'year' => $year,
            'months' => $months,
            'countWeeks' => $countWeeks,
        ])->setPaper('a4', 'landscape')
            ->setOption('dpi', 200)
            ->setOption('defaultFont', 'Courier');

        // return $pdf->stream('report_' . ($project->project_nama ?? 'project') . "_{$year}.pdf");

        // Generate angka acak untuk nama file

        $randomNumber = random_int(100000, 999999);

        // Return response stream download dengan nama file yang aman
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "report_" . ($project->project_nama ?? 'project') . "_{$year}_{$randomNumber}.pdf");
    }

    public function downloadExcel(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $projectId = $request->get('project', 0);

        $projects = Proyek::with([
            'scopes' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities' => function ($query) {
                $query->where('isActive', 1);
            },
            'scopes.activities.pics',
            'scopes.activities.pics.bagian',
            'scopes.activities.progress' => function ($query) {
                $query->latest('created_at')->get(); // Mengambil progress terbaru
            },
        ])->where('isActive', 1)
            ->where(function ($query) use ($projectId) {
                if ($projectId != 0) {
                    $query->where('id_project', $projectId);
                }
            })
            // ->whereYear('created_at', $this->year)
            ->get();


        // return response()->json($projects);
        $months = [];
        $countWeeks = 0;

        // Loop untuk setiap bulan dalam tahun ini
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            // Menghitung jumlah minggu dalam bulan
            $weeks = $this->countWeeksInMonth($startDate, $endDate);
            $countWeeks += $weeks;
            $months[$month] = [
                'month' => $startDate->format('F'),
                'weeks' => $weeks,
            ];
        }

        foreach ($projects as $project) {
            foreach ($project->scopes as $scope) {
                foreach ($scope->activities as $activity) {
                    $planStart = $activity->plan_start ? Carbon::parse($activity->plan_start) : null;
                    $planDuraton = $activity->plan_duration;
                    $actualStart = $activity->actual_start ? Carbon::parse($activity->actual_start) : null;
                    $actualDuraton = $activity->actual_duration;
                    // dd($activity, $actualStart);
                    $planWeekStart = 0;
                    $planWeekEnd = 0;
                    $countWeekPlan = 0;
                    if ($planStart && $planStart->format('Y') == $year) {
                        foreach ($months as $key => $month) {
                            if ($month['month'] == $planStart->format('F')) {
                                $planWeekStart = $this->StartWeeks($planStart, $countWeekPlan);
                                $plan_duration = $planDuraton - 1;
                                $start_date_raw = $planStart->copy();
                                $end_plan = $start_date_raw->modify("+{$plan_duration} weeks");
                                $planWeekEnd = $this->EndWeek($end_plan, $countWeekPlan);
                            } else {
                                $countWeekPlan += $month['weeks'];
                            }
                        }
                    }

                    $actualWeekStart = 0;
                    $actualWeekEnd = 0;
                    $countWeekActual = 0;
                    if ($actualStart && $actualStart->format('Y') == $year) {
                        foreach ($months as $key => $month) {
                            if ($month['month'] == $actualStart->format('F')) {
                                $actualWeekStart = $this->StartWeeks($actualStart, $countWeekActual);
                                $actual_duration = $actualDuraton - 1;
                                $start_actual_raw = $actualStart->copy();
                                $end_actual = $start_actual_raw->modify("+{$actual_duration} weeks");
                                $actualWeekEnd = $this->EndWeek($end_actual, $countWeekActual);
                            } else {
                                $countWeekActual += $month['weeks'];
                            }
                        }
                    }
                    $activity->plan_week_start = $planWeekStart;
                    $activity->plan_week_end = $planWeekEnd;
                    $activity->actual_week_start = $actualWeekStart;
                    $activity->actual_week_end = $actualWeekEnd;
                }
            }
        }

        $randomNumber = random_int(100000, 999999);

        return Excel::download(new ProgressDataExport($projects, $year, $months, $countWeeks), "report_{$randomNumber}.xlsx");
    }

    private function countWeeksInMonth(Carbon $startDate, Carbon $endDate)
    {
        $weeks = 0;
        $currentDate = $startDate->copy();

        // banyak hari dalam bulan
        $countDays = \cal_days_in_month(\CAL_GREGORIAN, $currentDate->month, $currentDate->year);

        $startDays = (new DateTime($currentDate))->format('N');
        // dd($currentDate);

        $countWeeks = intval(ceil(($countDays + ($startDays - 1)) / 7));
        return $countWeeks;
    }

    private function StartWeeks(Carbon $date, $countWeek)
    {
        $firstDayOfMonth = $date->copy()->startOfMonth();
        $weekInMonth = 0;

        $firstWeekDayNumber = $firstDayOfMonth->dayOfWeekIso; // 1 = Senin, 7 = Minggu
        $offsetDays = 7 - ($firstWeekDayNumber - 1);

        if ($date->day <= $offsetDays) {
            $weekInMonth = 1;
        }

        $weekInMonth = (int) ceil(($date->day - $offsetDays) / 7) + 1;

        return $countWeek + $weekInMonth;
    }

    private function EndWeek(Carbon $date, $countWeek)
    {
        // asumsi $date merupakan end_data
        $firstDayOfMonth = $date->copy()->startOfMonth();
        $weekInMonth = 0;

        $firstWeekDayNumber = $firstDayOfMonth->dayOfWeekIso; // 1 = Senin, 7 = Minggu
        $offsetDays = 7 - ($firstWeekDayNumber - 1);

        if ($date->day <= $offsetDays) {
            $weekInMonth = 1;
        }

        $weekInMonth = (int) ceil(($date->day - $offsetDays) / 7) + 1;

        return $countWeek + $weekInMonth;
    }

    private function EndWeekWithCrossMonthHandling(Carbon $startDate, $plan_duration, $countWeek, $nextMonth, $thisMonth)
    {
        // Hitung tanggal akhir berdasarkan durasi minggu yang diberikan
        $end_plan = $startDate->copy()->modify("+{$plan_duration} weeks");

        // Hitung minggu keberapa di bulan sekarang
        $endMonthWeek = $this->StartWeeks($end_plan, $countWeek);

        // Jika $end_plan jatuh di hari terakhir bulan ini dan termasuk minggu pertama bulan depan
        $lastDayOfMonth = $end_plan->copy()->endOfMonth();
        $firstDayOfNextMonth = $end_plan->copy()->addMonthNoOverflow()->startOfMonth();

        // Jika tanggal akhir adalah di minggu terakhir bulan ini
        if ($end_plan->greaterThanOrEqualTo($lastDayOfMonth->subDays(6))) {
            // Cek apakah hari setelah $end_plan ada di minggu pertama bulan depan
            if ($end_plan->isSameMonth($firstDayOfNextMonth) == false && $end_plan->dayOfWeekIso != 1) {
                // Jika $end_plan juga terhitung sebagai minggu pertama di bulan depan
                return [
                    'weekOfMonth' => 1, // Minggu pertama bulan depan
                    'month' => $firstDayOfNextMonth->format('F'),
                    'year' => $firstDayOfNextMonth->year,
                ];
            }
        }

        // Jika tidak jatuh pada bulan depan, kembalikan minggu keberapa di bulan sekarang
        if ($end_plan->format('F') == $nextMonth['month']) {
            $endMonthWeek = $endMonthWeek + $thisMonth['weeks'] + 1;
        }

        return [
            'weekOfMonth' => $endMonthWeek,
            'month' => $end_plan->format('F'),
            'year' => $end_plan->year,
        ];
    }

    private function countFullWeeksInMonth(Carbon $startDate, Carbon $endDate)
    {
        $weeks = 0;
        $currentDate = $startDate->copy()->startOfWeek();

        // Menghitung minggu penuh dalam rentang bulan
        while ($currentDate->lte($endDate)) {
            if ($currentDate->copy()->endOfWeek()->lte($endDate)) {
                $weeks++;
            }
            $currentDate->addWeek();
        }

        return $weeks;
    }

    private function countWeeksInMonthWithOverlap(Carbon $startDate, Carbon $endDate)
    {
        $weeks = 0;
        $currentDate = $startDate->copy()->startOfWeek();
        $endOfMonth = $endDate->copy()->endOfMonth();

        while ($currentDate->lte($endOfMonth)) {
            // Hitung jumlah hari dalam minggu saat ini yang masuk ke bulan ini
            $daysInThisMonth = $this->countDaysInCurrentMonth($currentDate, $endOfMonth);

            // Hitung jumlah hari di minggu pertama bulan berikutnya (jika ada)
            $startOfNextMonth = $endOfMonth->copy()->addDay(); // 1 April
            $daysInNextMonthFirstWeek = $this->countDaysInCurrentMonth($startOfNextMonth->startOfWeek(), $startOfNextMonth->endOfWeek());

            if ($daysInThisMonth >= $daysInNextMonthFirstWeek) {
                // Minggu terakhir dihitung sebagai minggu bulan ini
                $weeks++;
            } else {
                // Minggu terakhir dihitung sebagai bagian dari bulan selanjutnya
                break;
            }

            // Tambah minggu
            $currentDate->addWeek();
        }

        return $weeks;
    }

    private function countDaysInCurrentMonth(Carbon $weekStart, Carbon $endOfMonth)
    {
        $daysInMonth = 0;
        $weekEnd = $weekStart->copy()->endOfWeek();

        // Hitung hanya hari-hari dalam bulan ini
        for ($date = $weekStart->copy(); $date->lte($weekEnd) && $date->lte($endOfMonth); $date->addDay()) {
            $daysInMonth++;
        }

        return $daysInMonth;
    }
}
