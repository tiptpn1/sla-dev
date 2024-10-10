<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Gantt Chart</title>
    {{-- <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/dhtmlx-gantt-chart/codebase/sources/dhtmlxgantt.css') }}">
    {{-- <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script> --}}
    <script src="{{ asset('plugins/dhtmlx-gantt-chart/codebase/sources/dhtmlxgantt.js') }}"></script>

    <style>
        /* Menyembunyikan konten bar tugas */
        .gantt_task_line.gantt_bar_task > .gantt_task_content {
            display: none !important;
        }


        .gantt_grid_head_cell {
            white-space: normal; /* Membungkus teks panjang ke baris berikutnya */
            word-wrap: break-word; /* Memecah kata yang panjang */
            overflow-wrap: break-word; /* Memastikan kata panjang tidak melampaui batas */
            word-break: break-word; /* Memecah kata panjang untuk pembungkusan */
            font-size: 12px; /* Ukuran font header kolom */
            font-weight: bold; /* Menebalkan teks header */
            padding: 4px; /* Padding di dalam sel header */
            box-sizing: border-box; /* Menyertakan padding dalam lebar elemen */
        }

        /* Mengatur gaya untuk isi sel Gantt */
        .gantt_tree_content {
            white-space: normal; /* Membungkus teks panjang ke baris berikutnya */
            word-wrap: break-word; /* Memecah kata yang panjang */
            overflow-wrap: break-word; /* Memastikan kata panjang tidak melampaui batas */
            word-break: break-word; /* Memecah kata panjang untuk pembungkusan */
            font-size: 12px; /* Ukuran font isi sel */
            padding: 4px; /* Padding di dalam sel */
            box-sizing: border-box; /* Menyertakan padding dalam lebar elemen */
            line-height: 1.2; /* Menyesuaikan tinggi baris untuk membuat teks lebih mudah dibaca */
        }

        /* Menyesuaikan tinggi baris secara otomatis */
        .gantt_grid_body .gantt_grid_row {
            height: auto; /* Mengatur tinggi baris otomatis */
        }

        .gantt_container {
        display: flex;
        width: 100%;
        }

        .gantt_column_wrap {
            white-space: normal;
            word-wrap: break-word;
        }

    </style>


</head>

<body>
    
    <div class="row">
        <div class="col-auto mr-auto"></div>
        <div class="col-auto mb-2" style="text-align: right;" >
            <p style="margin: 0; font-size: 14px;">
                <span style="display: inline-block; width: 40px; height: 10px; background-color: #007bff; border-radius: 5px; margin-right: 3px;"></span>
                Plan
                &nbsp;
                <span style="display: inline-block; width: 40px; height: 10px; background-color: #3db9d3; border-radius: 5px; margin-right: 3px; margin-left: 10px;"></span>
                Actual
            </p>
        </div>
      </div>
    
    <div id="gantt_here" style="width:100%; height:500px;"></div>

    

    <script>
        gantt.config.date_format = "%Y-%m-%d";

        // Konfigurasi Gantt Chart
        gantt.config.scale_unit = "month"; // Unit utama skala adalah bulan
        gantt.config.date_scale = "%F %Y"; // Tampilkan nama bulan dan tahun (Januari 2024, dst.)

        // Sub skala untuk minggu 1-4 di setiap bulan
        gantt.config.subscales = [{
            unit: "week",
            step: 1,
            template: function(date) {
                var weekNum = gantt.date.getWeek(date);
                var monthStartWeek = gantt.date.getWeek(gantt.date.month_start(date));
                var weekInMonth = weekNum - monthStartWeek + 1;

                // Batasi hanya hingga minggu 4
                if (weekInMonth < 1 || weekInMonth > 5) {
                    return "Week 1";
                }
                return "Week " + weekInMonth;
            }
        }];

        gantt.config.scale_height = 60; // Tinggi skala (header)
        gantt.config.row_height = 60; // Tinggi setiap baris aktivitas
        gantt.config.bar_height = 20; // Tinggi bar Gantt untuk setiap aktivitas

        // Batasi tampilan Gantt Chart hingga Desember
        gantt.config.start_date = new Date(2024, 0, 1); // 1 Januari 2024
        gantt.config.end_date = new Date(2024, 11, 31); // 31 Desember 2024

        gantt.config.readonly = true; // Nonaktifkan mode hanya baca
        // gantt.config.resizable = true;

        // gantt.attachEvent("onBeforeTaskDrag", function(id, mode) {
        //     return true; // Mengizinkan drag
        // });

        gantt.config.layout = {
        css: "gantt_container",
        cols: [
            {
                width: 500, // lebar tabel (sidebar)
                min_width: 300,
                rows: [
                    { view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer" },
                    { view: "scrollbar", id: "gridScroll", group: "horizontal" }
                ]
            },
            { resizer: true, width: 1 },
            {
                rows: [
                    { view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer" },
                    { view: "scrollbar", id: "scrollHor", group: "horizontal" }
                ]
            },
            { view: "scrollbar", id: "scrollVer" }
        ]
        };

        gantt.init("gantt_here");

        gantt.config.columns = [
            {
                name: "proyek",
                label: "Proyek",
                tree: false,
                width: 150,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "scope",
                label: "Ruang Lingkup",
                tree: false,
                width: 150,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "activity",
                label: "Nama Aktivitas",
                tree: false,
                width: 180,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "start_date_data_plan",
                label: "Start Plan",
                tree: false,
                width: 100,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "duration_data_plan",
                label: "Duration Plan",
                tree: false,
                width: 100,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "start_date_data_actual",
                label: "Start Actual",
                tree: false,
                width: 100,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "duration_data_actual",
                label: "Duration Actual",
                tree: false,
                width: 100,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "percent",
                label: "Percent Complete",
                width: 100,
                align: "center",
                template: function(item) {
                    return item.progress + "%";
                },
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "pic",
                label: "PIC",
                align: "center",
                width: 80,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "rincian",
                label: "Rincian Progress",
                align: "center",
                width: 120,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "evidence",
                label: "Evidence",
                align: "center",
                width: 120,
                css: "wrap-text gantt_column_wrap"
            },
            {
                name: "tanggal",
                label: "Tanggal Rincian",
                align: "center",
                width: 120,
                css: "wrap-text gantt_column_wrap"
            },
        ];


        @php
            $arrayProyek = [];
            $arrayScope = [];
        @endphp

        gantt.parse({
            data: [
                @foreach ($projects as $project)
                    @if (count($project->scopes->where('isActive', 1)))
                        @foreach ($project->scopes->where('isActive', 1) as $sc)
                            @if (count($sc->activities->where('isActive', 1)))
                                @foreach ($sc->activities->where('isActive', 1) as $activity)
                                    @php
                                        $scope = '';
                                        $proyek = '';
                                        if (!in_array($project->id_project, $arrayProyek)) {
                                            $proyek = $project->project_nama;
                                            array_push($arrayProyek, $project->id_project);
                                        }
                                        if (!in_array($sc->id, $arrayScope)) {
                                            $scope = $sc->nama;
                                            array_push($arrayScope, $sc->id);
                                        }

                                        $activity->end_date_plan_bar = '';
                                        $activity->start_date_plan_bar = '';
                                        if ($activity->plan_start != null && $activity->plan_duration != null) {
                                            $start_plan = new \DateTime($activity->plan_start);
                                            $start_plan_raw = new \DateTime($activity->plan_start);
                                            $plan_duration = $activity->plan_duration - 1;
                                            $end_plan = $start_plan->modify("+{$plan_duration} week");
                                            $end_plan = $end_plan->format('N') != 1? $end_plan->modify('This Monday') : $end_plan->modify('Next Monday');
                                            $activity->end_date_plan_bar = $end_plan->format('Y-m-d');
                                            $activity->start_date_plan_bar = $start_plan_raw->format('N') != 1? $start_plan_raw->modify('Last Monday')->format('Y-m-d') : $start_plan_raw->format('Y-m-d');
                                        }

                                        $activity->end_date_actual_bar = '';
                                        $activity->start_date_actual_bar = '';
                                        if ($activity->actual_start != null && $activity->actual_duration != null) {
                                            $start_actual = new \DateTime($activity->actual_start);
                                            $start_actual_raw = new \DateTime($activity->actual_start);
                                            $actual_duration = $activity->actual_duration - 1;
                                            $end_actual = $start_actual->modify("+{$actual_duration} week");
                                            $end_actual = $end_actual->format('N') != 1? $end_actual->modify('This Monday') : $end_actual->modify('Next Monday');
                                            $activity->end_date_actual_bar = $end_actual->format('Y-m-d');
                                            $activity->start_date_actual_bar = $start_actual_raw->format('N') != 1? $start_actual_raw->modify('Last Monday')->format('Y-m-d') : $start_actual_raw->format('Y-m-d');
                                        }

                                        $pics = [];

                                        foreach ($activity->pics as $pic) {
                                            array_push($pics, $pic->bagian->master_bagian_kode);
                                        }

                                        if (count($activity->progress)) {
                                            $rincian_progress = $activity->progress->sortByDesc('tanggal')[0];
                                            $tanggal = $activity->progress->sortByDesc('tanggal')[0];
                                            $evidence = $rincian_progress->evidences != null ? $rincian_progress->evidences->sortByDesc('created_at')[0]->filename : '';
                                        } else {
                                            $rincian_progress = '';
                                            $evidence = '';
                                            $tanggal = '';
                                        }

                                    @endphp {
                                        id: '{{ $activity->id_activity }}',
                                        proyek: '{{ $proyek }}',
                                        scope: '{{ $scope }}',
                                        activity: '{{ $activity->nama_activity }}',
                                        start_date_plan: @if ($activity->start_date_plan_bar != '')
                                            new Date(
                                                '{{ $activity->start_date_plan_bar }} ')
                                        @else
                                            new Date()
                                        @endif , // untuk bar
                                        start_date_data_plan: '{{ $activity->plan_start }}', // untuk kolom
                                        end_date_plan: @if ($activity->end_date_plan_bar != '')
                                            new Date(
                                                '{{ $activity->end_date_plan_bar }} ')
                                        @else
                                            new Date()
                                        @endif , // untuk bar
                                        duration_data_plan: '{{ $activity->plan_duration }}',
                                        start_date: '{{ $activity->start_date_actual_bar != '' ? $activity->start_date_actual_bar : ($activity->start_date_plan_bar != '' ? $activity->start_date_plan_bar : now()) }}', // untuk bar
                                        start_date_data_actual: '{{ $activity->actual_start }}', // untuk kolom data
                                        end_date: '{{ $activity->end_date_actual_bar != '' ? $activity->end_date_actual_bar : ($activity->end_date_plan_bar != '' ? $activity->end_date_plan_bar : now()) }}', // untuk bar
                                        duration_data_actual: '{{ $activity->actual_duration }}',
                                        percent: '{{ $activity->percent_complete }}',
                                        pic: '{{ implode(', ', $pics) }}',
                                        rincian: '{{ $rincian_progress != '' ? $rincian_progress->rincian_progress : '' }}',
                                        evidence: '{{ $evidence }}',
                                        tanggal: '{{ $tanggal != '' ? $rincian_progress->tanggal : '' }}',

                                    },
                                @endforeach
                            @else
                                @php
                                    $proyek = '';
                                    if (!in_array($project->id_project, $arrayProyek)) {
                                        $proyek = $project->project_nama;
                                        array_push($arrayProyek, $project->id_project);
                                    }
                                @endphp {
                                    id: 'scopes {{ $sc->id }}',
                                    proyek: '{{ $proyek }}',
                                    scope: '{{ $sc->nama }}',
                                    activity: '',
                                    start_date_plan: new Date(), // untuk bar
                                    start_date_data_plan: '', // untuk kolom
                                    end_date_plan: new Date(), // untuk bar
                                    duration_data_plan: '',
                                    start_date: '{{ now() }}', // untuk bar
                                    start_date_data_actual: '', // untuk kolom data
                                    end_date: '{{ now() }}', // untuk bar
                                    duration_data_actual: '',
                                    percent: '0',
                                    pic: '',
                                    rincian: '',
                                    evidence: '',
                                    tanggal: '',
                                },
                            @endif
                        @endforeach
                    @else
                        {
                            id: 'project{{ $project->id_project }}',
                            proyek: '{{ $project->project_nama }}',
                            scope: '',
                            activity: '',
                            start_date_plan: new Date(), // untuk bar
                            start_date_data_plan: '', // untuk kolom
                            end_date_plan: new Date(), // untuk bar
                            duration_data_plan: '',
                            start_date: '{{ now() }}', // untuk bar
                            start_date_data_actual: '', // untuk kolom data
                            end_date: '{{ now() }}', // untuk bar
                            duration_data_actual: '',
                            percent: '0',
                            pic: '',
                            rincian: '',
                            evidence: '',
                            tanggal: '',
                        },
                    @endif
                @endforeach
            ]


        });
    </script>

</body>

</html>
