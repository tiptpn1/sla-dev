<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartController extends Controller
{
    public function terimaKeluar()
    {
        try {
            $totalPembayaran = DB::table('spp')
                ->join('sppb', 'spp.sppb_id', '=', 'sppb.sppb_id')
                ->whereNotNull('spp.sppb_id')
                ->where('spp.company_id', 5)
                ->whereIn('spp.sppd_posisi', [38, 39])
                ->whereIn('spp.sppd_status', [1, 2, 100])
                ->sum('sppb.sppb_total');


            $totalPenerimaan = DB::table('spp')
                ->join('sppn', 'spp.sppn_id', '=', 'sppn.sppn_id')
                ->whereNotNull('spp.sppn_id')
                ->where('spp.company_id', 5)
                ->whereIn('spp.sppd_posisi', [38, 39])
                ->whereIn('spp.sppd_status', [1, 2, 100])
                ->sum('sppn.sppn_jumlah');

            return response()->json([
                'status' => 'success',
                'message' => 'Success get data penerimaan pengeluaran',
                'data' => [
                    'nama_region' => 'Head Office',
                    'total_pembayaran' => $totalPembayaran,
                    'total_penerimaan' => $totalPenerimaan
                ]
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'errors' => [
                    'message' => [
                        $th->getMessage()
                    ],
                ],
            ], 500);
        }
    }

    function getSppbdanSppnTerbayarPerRegional()
    {
        try {
            $user_company = 5;
            $hak_akses = 1;

            $allRegional = DB::table('master_company')
                ->where('company_nama', 'LIKE', '%Regional%')
                ->select('company_id', 'company_kode');
            // ->orWhere('company_id','=', 5);

            if (!in_array($hak_akses, [1, 46])) {
                $allRegional->where('company_id', '=', $user_company);
            }
            Log::info('Ambil data regional', [$allRegional->get()]);

            $all_spp = DB::table('spp')
                ->select('spp_id', 'company_id', 'spp_tanggal')
                ->where('spp_status_bayar', 1)
                ->where('spp.sppd_posisi', 39)
                ->where('spp.sppd_status', 1);

            Log::debug('Ambil data spp');

            Log::debug("Cek tanggal awal dan akhir");

            $allSppb = DB::table('spp')
                ->join('sppb', 'spp.sppb_id', '=', 'sppb.sppb_id')
                ->select('spp.master_bagian_id', 'spp.company_id', 'sppb.sppb_total')
                ->whereIn('spp.sppd_posisi', [38, 39])
                ->whereIn('spp.sppd_status', [1, 2, 100]);

            $allSppn = DB::table('spp')
                ->join('sppn', 'spp.sppn_id', '=', 'sppn.sppn_id')
                ->select('spp.master_bagian_id', 'spp.company_id', 'sppn.sppn_jumlah')
                ->whereIn('spp.sppd_posisi', [38, 39])
                ->whereIn('spp.sppd_status', [1, 2, 100]);

            $regionalData = DB::table(DB::raw('(' . $allRegional->toSql() . ') as ar'))
                ->leftJoin(DB::raw('(' . $allSppb->toSql() . ') as asp'), 'ar.company_id', '=', 'asp.company_id')
                ->leftJoin(DB::raw('(' . $allSppn->toSql() . ') as asn'), 'ar.company_id', '=', 'asn.company_id')
                ->mergeBindings($allRegional)
                ->mergeBindings($allSppb)
                ->mergeBindings($allSppn)
                ->select(
                    'ar.company_kode as company',
                    DB::raw('COALESCE(SUM(DISTINCT asp.sppb_total), 0) AS total_sppb'),
                    DB::raw('COALESCE(SUM(DISTINCT asn.sppn_jumlah), 0) AS total_sppn')
                )
                ->groupBy('ar.company_kode');

            if (in_array($hak_akses, [1, 46])) {
                $hoData = DB::table(DB::raw('(' . $allSppb->toSql() . ') as asp'))
                    ->mergeBindings($allSppb)
                    ->select(
                        DB::raw("'HO' AS company"),
                        DB::raw('COALESCE(SUM(asp.sppb_total), 0) AS total_sppb'),
                        DB::raw('(SELECT COALESCE(SUM(asn2.sppn_jumlah), 0)
                          FROM (' . $allSppn->toSql() . ') as asn2
                          WHERE asn2.company_id = asp.company_id) AS total_sppn')
                    )
                    ->mergeBindings($allSppn)
                    ->where('asp.company_id', 5);
                // $hoData = DB::table(DB::raw('(' . $allSppb->toSql() . ') as asp'))
                //     ->leftJoin(DB::raw('(' . $allSppn->toSql() . ') as asn'), 'asp.company_id', '=', 'asn.company_id')
                //     ->mergeBindings($allSppb)
                //     ->mergeBindings($allSppn)
                //     ->select(
                //         DB::raw("'HO' AS company"),
                //         DB::raw('COALESCE(SUM(asp.sppb_total), 0) AS total_sppb'),
                //         DB::raw('COALESCE(SUM(asn.sppn_jumlah), 0) AS total_sppn')
                //     )
                //     ->where('asp.company_id', 5);

                Log::debug("Get data dari database", [$hoData->get()]);

                // Combine both queries using `unionAll`.
                $finalQuery = $hoData->unionAll($regionalData)->get();
                $results = $finalQuery;
            } else {
                $results = $regionalData->get();
            }

            $transformedResults = [];

            foreach ($results as $result) {
                $transformedResults[] = [
                    "company" => $result->company,
                    "jenis" => "Cash Out",
                    "total" => $result->total_sppb
                ];
                $transformedResults[] = [
                    "company" => $result->company,
                    "jenis" => "Cash In",
                    "total" => $result->total_sppn
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'success get data Sppb dan Sppn Terbayar Per Rewgional',
                'data' => $transformedResults,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => [
                    'message' => [
                        $th->getMessage()
                    ],
                ],
            ], 500);
        }
    }

    public function getSppbAllCompany()
    {
        $currentYear = date('Y');
        $sppb = DB::table('spp')
            ->join('sppb', 'spp.sppb_id', '=', 'sppb.sppb_id')
            ->join('master_company as company', 'spp.company_id', '=', 'company.company_id')
            ->select(
                'company.company_kode',
                DB::raw("DATE_FORMAT(spp.spp_tanggal, '%Y-%m') as bulan"),
                DB::raw('SUM(sppb.sppb_total) as sppb_total')
            )
            ->whereYear('spp.spp_tanggal', $currentYear)
            ->groupBy('company.company_kode', 'bulan')
            ->orderBy('company.company_kode')
            ->orderBy('bulan')
            ->get();

        $bulanIndonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $companyData = [];
        foreach ($sppb->groupBy('company_kode') as $companyKode => $dataPerCompany) {
            $companyData[$companyKode] = [];
            foreach ($bulanIndonesia as $monthNumber => $monthName) {
                // Cek apakah bulan ini ada dalam data
                $dataBulan = $dataPerCompany->firstWhere('bulan', "$currentYear-$monthNumber");

                $companyData[$companyKode][] = [
                    'company_kode' => $companyKode,
                    'bulan' => $monthName,
                    'sppb_total' => $dataBulan ? $dataBulan->sppb_total : 0,
                ];
            }
        }

        // Menggabungkan data menjadi satu array
        $flattenedData = [];
        foreach ($companyData as $companyRows) {
            foreach ($companyRows as $row) {
                $flattenedData[] = $row;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'success get data sppb all company',
            'data' => $flattenedData,
        ]);
    }
    public function getSppnAllCompany()
    {
        $currentYear = Date('Y');
        $sppn = DB::table('spp')
            ->join('sppn', 'spp.sppn_id', '=', 'sppn.sppn_id')
            ->join('master_company as company', 'spp.company_id', '=', 'company.company_id')
            ->select(
                'company.company_kode',
                DB::raw("DATE_FORMAT(spp.spp_tanggal, '%Y-%m') as bulan"),
                DB::raw('SUM(sppn.sppn_jumlah) as sppn_jumlah')
            )
            ->whereYear('spp.spp_tanggal', $currentYear)
            ->groupBy('company.company_kode', 'bulan')
            ->orderBy('company.company_kode')
            ->orderBy('bulan')
            ->get();

        $bulanIndonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $companyData = [];
        foreach ($sppn->groupBy('company_kode') as $companyKode => $dataPerCompany) {
            $companyData[$companyKode] = [];
            foreach ($bulanIndonesia as $monthNumber => $monthName) {
                // Cek apakah bulan ini ada dalam data
                $dataBulan = $dataPerCompany->firstWhere('bulan', "$currentYear-$monthNumber");

                $companyData[$companyKode][] = [
                    'company_kode' => $companyKode,
                    'bulan' => $monthName,
                    'sppn_jumlah' => $dataBulan ? $dataBulan->sppn_jumlah : 0,
                ];
            }
        }

        // Menggabungkan data menjadi satu array
        $flattenedData = [];
        foreach ($companyData as $companyRows) {
            foreach ($companyRows as $row) {
                $flattenedData[] = $row;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'success get data sppn all company',
            'data' => $flattenedData,
        ]);
    }

    public function getSppbSppnAllCompany()
    {
        $currentYear = date('Y');

        // Query untuk sppb (cash_out)
        $sppb = DB::table('spp')
            ->join('sppb', 'spp.sppb_id', '=', 'sppb.sppb_id')
            ->join('master_company as company', 'spp.company_id', '=', 'company.company_id')
            ->select(
                'company.company_kode',
                DB::raw("DATE_FORMAT(spp.spp_tanggal, '%Y-%m') as bulan"),
                DB::raw('SUM(sppb.sppb_total) as cash_out')
            )
            ->whereYear('spp.spp_tanggal', $currentYear)
            ->groupBy('company.company_kode', 'bulan')
            ->orderBy('company.company_kode')
            ->orderBy('bulan')
            ->get()
            ->groupBy('company_kode'); // Mengelompokkan hasil berdasarkan company_kode

        // Query untuk sppn (cash_in)
        $sppn = DB::table('spp')
            ->join('sppn', 'spp.sppn_id', '=', 'sppn.sppn_id')
            ->join('master_company as company', 'spp.company_id', '=', 'company.company_id')
            ->select(
                'company.company_kode',
                DB::raw("DATE_FORMAT(spp.spp_tanggal, '%Y-%m') as bulan"),
                DB::raw('SUM(sppn.sppn_jumlah) as cash_in')
            )
            ->whereYear('spp.spp_tanggal', $currentYear)
            ->groupBy('company.company_kode', 'bulan')
            ->orderBy('company.company_kode')
            ->orderBy('bulan')
            ->get()
            ->groupBy('company_kode'); // Mengelompokkan hasil berdasarkan company_kode

        // List bulan dalam bahasa Indonesia
        $bulanIndonesia = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Gabungkan data sppb dan sppn berdasarkan company_kode dan bulan
        $companyData = [];
        foreach ($sppb as $companyKode => $dataPerCompany) {
            $companyData[$companyKode] = [];

            foreach ($bulanIndonesia as $monthNumber => $monthName) {
                $bulanFormat = "$currentYear-$monthNumber";

                // Dapatkan nilai cash_out dari sppb
                $dataCashOut = $dataPerCompany->firstWhere('bulan', $bulanFormat);
                $cashOut = $dataCashOut ? $dataCashOut->cash_out : 0;

                // Dapatkan nilai cash_in dari sppn untuk bulan dan company yang sama
                $dataCashIn = $sppn->get($companyKode, collect())->firstWhere('bulan', $bulanFormat);
                $cashIn = $dataCashIn ? $dataCashIn->cash_in : 0;

                $companyData[$companyKode][] = [
                    'company_kode' => $companyKode,
                    'bulan' => $monthName,
                    'cash_out' => $cashOut,
                    'cash_in' => $cashIn,
                ];
            }
        }

        // Menggabungkan data menjadi satu array
        $flattenedData = [];
        foreach ($companyData as $companyRows) {
            foreach ($companyRows as $row) {
                $flattenedData[] = $row;
            }
        }

        // Kembalikan response JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Success get data sppb and sppn by company and month for current year',
            'data' => $flattenedData,
        ]);
    }
}
