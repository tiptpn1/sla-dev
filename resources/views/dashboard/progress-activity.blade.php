@extends('master/master')

@section('title', 'Gantt Chart Monitoring Program Kerja')
@section('progress-activity', 'active')

@section('content')
    <x-progress-activity />

    <script>
        $(document).ready(function() {
            var selectedYear = $('#filter-year').val() || new Date().getFullYear();
            
            $.ajax({
                url: '{{ route('ganchart') }}',
                method: 'GET',
                data: { year: selectedYear },
                success: function(response) {
                    $('#gantt-chart-field').html(response);
                }
            })

            // Year filter change event
            $('#filter-year').on('change', function() {
                var selectedYear = $(this).val();
                gantt.config.start_date = new Date(selectedYear, 0, 1);
                gantt.config.readonly = true;
                
                $.ajax({
                    url: '{{ route('ganchart') }}',
                    method: 'GET',
                    data: { year: selectedYear },
                    success: function(response) {
                        $('#gantt-chart-field').html(response);
                        // You may need to reinitialize gantt here depending on your setup
                    }
                });
            });

            $('#reportPdfForm').on('submit', function(e) {
                e.preventDefault(); // Prevent normal form submission

                var year = $('#year').val();
                var projectId = $('#project').val();
                var projectName = $('#project option:selected').data('name'); // Get project name
                var randomNum = Math.floor(Math.random() * 100000); // Generate random number
            });
        });

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

            // You might need to reinitialize gantt here depending on how your code works
            // gantt.init("gantt_here");
            // gantt.parse(data);
    
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
                                        $rincian_progress = $activity->progress->sortByDesc('tanggal')->first();
                                        $tanggal = $rincian_progress ? $rincian_progress->tanggal : '';
                                        $evidence = $rincian_progress && $rincian_progress->evidences
                                            ? $rincian_progress->evidences->sortByDesc('created_at')->first()->filename ?? ''
                                            : '';
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
@endsection
