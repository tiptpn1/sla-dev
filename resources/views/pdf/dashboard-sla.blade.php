<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard SLA</title>
    <style>
        /* body {
            transform: scale(0.5);
        transform-origin: top left;
        }*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 32px;
        }

        td {
            font-size: 28px;
        }

        h2 {
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        /* Prevent large rows from breaking awkwardly */
        tr {
            page-break-inside: avoid;
        }

        .col-1 {
            width: 15%;
        }

        .col-2 {
            width: 8%;
            text-align: center;
        }

        .col-3 {
            width: 8%;
            text-align: center;
        }

        .col-4 {
            width: 8%;
            text-align: center;
        }

        .col-5 {
            width: 8%;
            text-align: center;
        }

        .col-6 {
            width: 8%;
            text-align: center;
        }

        .col-7 {
            width: 10%;
            text-align: center;
        }

        .col-8 {
            width: 10%;
            text-align: center;
        }

        .gantt-chart {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .gantt-chart th,
        .gantt-chart td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .gantt-chart .activity-name {
            text-align: left;
        }

        .bar {
            height: 20px;
            background-color: #4caf50;
            color: #fff;
            text-align: left;
            padding-left: 5px;
        }

        .bar.completed {
            background-color: #2196f3;
        }

        .bar.not-started {
            background-color: #e0e0e0;
        }

        .bar.in-progress {
            background-color: #ff9800;
        }
    </style>
</head>

<body>
    <h2>Dashboard SLA</h2>
    <p style="text-align: center; font-size: 40px; font-weight: bold">Project {{ $project->project_nama }} Tahun
        {{ $year }} </p>

    <table>
        <thead>
            <tr>
                <th class="col-1">Activity</th>
                <th class="col-2">Plan Start</th>
                <th class="col-3">Plan Duration (Weeks)</th>
                <th class="col-4">Actual Start</th>
                <th class="col-5">Actual Duration</th>
                <th class="col-6">% Complete</th>
                <th class="col-7">PIC</th>
                <th class="col-8">Rincian Progress</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($project->scopes as $scope)
                <tr>
                    <td colspan="8"
                        style="text-align: center; background-color: #ecfdfd; font-weight: bold; font-size: 30px; padding: 10px">
                        {{ $scope->nama }}</td>
                </tr>

                @foreach ($scope->activities as $activity)
                    <tr>
                        <td class="col-1">{{ $activity->nama_activity }}</td>
                        <td class="col-2">{{ $activity->plan_start }}</td>
                        <td class="col-3">{{ $activity->plan_duration }}</td>
                        <td class="col-4">{{ $activity->actual_start }}</td>
                        <td class="col-5">{{ $activity->actual_duration }}</td>
                        <td class="col-6">{{ $activity->percent_complete }}%</td>

                        <td class="col-7">
                            @if ($activity->pics->isNotEmpty())
                                @foreach ($activity->pics as $pic)
                                    {{ $pic->bagian->master_bagian_kode }} <br>
                                @endforeach
                            @else
                                &nbsp;
                            @endif
                        </td>

                        <td class="col-8">
                            @if ($activity->progress->isNotEmpty())
                                {{ $activity->progress->first()->rincian_progress }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach


        </tbody>
    </table>
    <div class="page-break"></div>

    <table class="gantt-chart">
        <thead>
            <tr>
                <th rowspan="3">Scope</th>
                <th rowspan="3">Activity</th>
                <th rowspan="3">Plan Start</th>
                <th rowspan="3">Actual Start</th>
                <th colspan="{{ $countWeeks }}">{{ $year }}</th>
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    <th colspan="{{ $month['weeks'] }}">{{ $month['month'] }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    @for ($i = 1; $i <= $month['weeks']; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($project->scopes as $scope)
                @foreach ($scope->activities as $activity)
                    <tr>
                        @if ($loop->first)
                            <td style="border: 1px solid #ddd">{{ $scope->nama }}</td>
                        @else
                            <td style="border: 0px solid ;"></td>
                        @endif
                        <td style="">{{ $activity->nama_activity }}</td>
                        <td style="">{{ $activity->plan_start }}</td>
                        <td style="">{{ $activity->actual_start }}</td>
                        @for ($i = 1; $i <= $countWeeks; $i++)
                            <td style="border: 0 solid #ddd;"></td>
                        @endfor
                    </tr>
                @endforeach
            @endforeach
            {{-- <tr>
                <td class="activity-name">{{ $project->scopes[0]->activities[0]->nama_activity }}</td>
                <td>{{ $project->scopes[0]->activities[0]->plan_duration }} days</td>
                <td>{{ $project->scopes[0]->activities[0]->actual_duration }} days</td>
                <td>
                    <div class="bar" style="width: {{ $project->activities[0]->percent_complete }}%;">
                        {{ $project->scopes[0]->activities[0]->percent_complete }}%
                    </div>
                </td>
            </tr> --}}
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</body>

</html>
