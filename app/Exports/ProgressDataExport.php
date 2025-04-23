<?php

namespace App\Exports;

use App\Models\Proyek;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProgressDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $projects;
    protected $year;
    protected $months;
    protected $countWeeks;

    function __construct($projects, $year, $months, $countWeeks)
    {
        $this->projects = $projects;
        $this->year = $year;
        $this->months = $months;
        $this->countWeeks = $countWeeks;
    }
    public function view(): View
    {

        return view('excel.dashboard-sla', [
            'projects' => $this->projects,
            'year' => $this->year,
            'months' => $this->months,
            'countWeeks' => $this->countWeeks,
        ]);
    }
}
