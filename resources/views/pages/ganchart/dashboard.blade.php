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
        .gantt_task_line.gantt_bar_task>.gantt_task_content {
            display: none !important;
        }

        /* .gantt_grid_head_cell {
            font-size: 8px;
            /* Mengatur ukuran font header kolom */
            font-weight: bold;
            /* Menebalkan teks header jika diinginkan */
        }

        .gantt_tree_content {
            font-size: 6px;
            /* Mengatur ukuran font isi sel */
        } */
    </style>
</head>

<body>
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
                if (weekInMonth < 1 || weekInMonth > 4) {
                    return "";
                }
                return "Week " + weekInMonth;
            }
        }];

        gantt.config.scale_height = 60; // Tinggi skala (header)
        gantt.config.row_height = 25; // Tinggi setiap baris aktivitas
        gantt.config.bar_height = 20; // Tinggi bar Gantt untuk setiap aktivitas

        // Batasi tampilan Gantt Chart hingga Desember
        gantt.config.start_date = new Date(1800, 0, 1); // 1 Januari 2024
        gantt.config.end_date = new Date(3024, 11, 31); // 31 Desember 2024

        gantt.config.readonly = true; // Nonaktifkan mode hanya baca

        gantt.init("gantt_here");

        gantt.config.columns = [{
                name: "proyek",
                label: "Proyek",
                tree: false,
                width: '*'
            },
            {
                name: "scope",
                label: "Ruang Lingkup",
                tree: false,
                width: '*',
            },
            {
                name: "activity",
                label: "Nama Aktivitas",
                tree: false,
                width: '*'
            },
            {
                name: "start_date_data_plan",
                label: "Start Plan",
                tree: false,
                width: '*',
            },
            {
                name: "duration_data_plan",
                label: "Duration Plan",
                tree: false,
                width: '*'
            },
            {
                name: "start_date_data_actual",
                label: "Start Actual",
                tree: false,
                width: '*'
            },
            {
                name: "duration_data_actual",
                label: "Duration Actual",
                tree: false,
                width: '*'
            },
            {
                name: "progress",
                label: "Percent Complete",
                width: '*',
                align: "center",
                template: function(item) {
                    return item.progress + "%";
                }
            },
            {
                name: "pic",
                label: "PIC",
                align: "center",
                width: '*'
            },
            {
                name: "rincian",
                label: "Rincian Progress",
                align: "center",
                width: '*'
            },
            {
                name: "evidence",
                label: "Evidence",
                align: "center",
                width: '*'
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
                                            $end_plan = $end_plan->modify('This Monday');
                                            $activity->end_date_plan_bar = $end_plan->format('Y-m-d');
                                            $activity->start_date_plan_bar = $start_plan_raw->modify('Last Monday')->format('Y-m-d');
                                        }

                                        $activity->end_date_actual_bar = '';
                                        $activity->start_date_actual_bar = '';
                                        if ($activity->actual_start != null && $activity->actual_duration != null) {
                                            $start_actual = new \DateTime($activity->actual_start);
                                            $start_actual_raw = new \DateTime($activity->actual_start);
                                            $actual_duration = $activity->actual_duration - 1;
                                            $end_actual = $start_actual->modify("+{$actual_duration} week");
                                            $end_actual = $end_actual->modify('This Monday');
                                            $activity->end_date_actual_bar = $end_actual->format('Y-m-d');
                                            $activity->start_date_actual_bar = $start_actual_raw->modify('Last Monday')->format('Y-m-d');
                                        }

                                        $pics = [];

                                        foreach ($activity->pics as $pic) {
                                            array_push($pics, $pic->bagian->master_bagian_kode);
                                        }

                                        if (count($activity->progress)) {
                                            $rincian_progress = $activity->progress->sortByDesc('created_at')[0];
                                            $evidence = $rincian_progress->evidences != null ? $rincian_progress->evidences->sortByDesc('created_at')[0]->filename : '';
                                        } else {
                                            $rincian_progress = '';
                                            $evidence = '';
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
                                        progress: '{{ $activity->percent_complete }}',
                                        pic: '{{ implode(', ', $pics) }}',
                                        rincian: '{{ $rincian_progress != '' ? $rincian_progress->rincian_progress : '' }}',
                                        evidence: '{{ $evidence }}',
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
                                    progress: '0',
                                    pic: '',
                                    rincian: '',
                                    evidence: '',
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
                            progress: '0',
                            pic: '',
                            rincian: '',
                            evidence: '',
                        },
                    @endif
                @endforeach
            ]
        });
    </script>

</body>

</html>
