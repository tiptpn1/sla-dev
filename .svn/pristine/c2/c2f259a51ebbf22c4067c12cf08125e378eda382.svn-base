<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait RoleTrait
{
    public function getRoleByBagianId($bagianId)
    {
        $bagianName = DB::table('kpi_master_bagian')->where('kpi_master_bagian_id', $bagianId)->pluck('kpi_master_bagian_nama')->first();

        if (strpos($bagianName, 'PMO') !== false) {
            return 'PMO';
        } else if (strpos($bagianName, 'Direktorat') !== false) {
            return 'Direktorat';
        } else if (strpos($bagianName, 'Divisi') !== false) {
            return 'Divisi';
        } else if (strpos($bagianName, 'Regional') !== false) {
            return 'Regional';
        } else if (strpos($bagianName, 'PTPN') !== false) {
            return 'PTPN';
        } else {
            return 'Unknown';
        }
    }
}
