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
    <h6>Didownload: {{ now() }}</h6>

    <table>
        <thead>
            <tr>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Project</th>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Scope</th>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Activity</th>
                <th rowspan="3" class="col-2"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Plan Start</th>
                <th rowspan="3" class="col-3"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Plan Duration (Weeks)</th>
                <th rowspan="3" class="col-4"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Actual Start</th>
                <th rowspan="3" class="col-5"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Actual Duration</th>
                <th rowspan="3" class="col-6"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    % Complete</th>
                <th rowspan="3" class="col-7"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    PIC</th>
                <th rowspan="3" class="col-8"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    Rincian Progress</th>
                <th colspan="{{ $countWeeks }}" class="col-9"
                    style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                    {{ $year }}</th>
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    <th colspan="{{ $month['weeks'] }}"
                        style="text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                        {{ $month['month'] }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    @for ($i = 1; $i <= $month['weeks']; $i++)
                        <th
                            style="width: 60px; text-align:center; font-weight:bold; font-size:9px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF; word-wrap: break-word; width: 60px; overflow-wrap: break-word; white-space: normal;">
                            Week {{ $i }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                @php
                    $totalProjectActivities = $project->scopes->sum(function ($scope) {
                        if (count($scope->activities) > 0) {
                            return $scope->activities->count();
                        } else {
                            return 1;
                        }
                    });

                    $headerProject = true;
                @endphp
                @if (count($project->scopes) > 0)
                    @foreach ($project->scopes as $scope)
                        @php
                            $headerScope = true;
                        @endphp
                        @if (count($scope->activities) > 0)
                            @php
                                $totalScopeActivities = $scope->activities->count();
                            @endphp
                            @foreach ($scope->activities as $activity)
                                <tr>
                                    {{-- Project rowspan --}}
                                    @if ($headerProject)
                                        @php
                                            $headerProject = false;
                                        @endphp
                                        <td rowspan="{{ $totalProjectActivities }}" class="nowrap"
                                            style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                            {{ $project->project_nama }}
                                        </td>
                                    @endif

                                    {{-- Scope rowspan --}}
                                    @if ($headerScope)
                                        @php
                                            $headerScope = false;
                                        @endphp
                                        <td rowspan="{{ $totalScopeActivities }}" class="nowrap"
                                            style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                            {{ $scope->nama }}</td>
                                    @endif

                                    {{-- Activity data --}}
                                    <td class="col-1"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 120px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->nama_activity }}</td>
                                    <td class="col-2"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->plan_start }}</td>
                                    <td class="col-3"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->plan_duration }}</td>
                                    <td class="col-4"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->actual_start }}</td>
                                    <td class="col-5"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->actual_duration }}</td>
                                    <td class="col-6"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $activity->percent_complete }}%</td>

                                    {{-- PICs --}}
                                    <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        @php
                                            $pics = [];
                                            foreach ($activity->pics as $pic) {
                                                array_push($pics, $pic->bagian->master_bagian_kode);
                                            }
                                        @endphp
                                        {{ implode(', ', $pics) }}
                                    </td>

                                    <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        @if ($activity->progress->isNotEmpty())
                                            {{ $activity->progress->first()->rincian_progress }}
                                        @endif
                                    </td>

                                    @php
                                        $indexWeek = 1;
                                    @endphp

                                    @foreach ($months as $key => $month)
                                        @for ($i = 1; $i <= $month['weeks']; $i++)
                                            @if (
                                                $indexWeek >= $activity->plan_week_start &&
                                                    $indexWeek <= $activity->plan_week_end &&
                                                    $indexWeek >= $activity->actual_week_start &&
                                                    $indexWeek <= $activity->actual_week_end)
                                                <td
                                                    style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; background-color:#24A0E4; word-wrap: break-word; width: 60px; overflow-wrap: break-word; white-space: normal;">
                                                </td>
                                            @elseif ($indexWeek >= $activity->plan_week_start && $indexWeek <= $activity->plan_week_end)
                                                <td
                                                    style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; background-color:#007BFF; word-wrap: break-word; width: 60px; overflow-wrap: break-word; white-space: normal;">
                                                </td>
                                            @elseif ($indexWeek >= $activity->actual_week_start && $indexWeek <= $activity->actual_week_end)
                                                <td
                                                    style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; background-color:#8AD0BF; word-wrap: break-word; width: 60px; overflow-wrap: break-word; white-space: normal;">
                                                </td>
                                            @else
                                                <td
                                                    style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 60px; overflow-wrap: break-word; white-space: normal;">
                                                </td>
                                            @endif
                                            @php
                                                $indexWeek++;
                                            @endphp
                                        @endfor
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                {{-- Project rowspan --}}
                                @if ($headerProject)
                                @php
                                    $headerProject = false;
                                @endphp
                                    <td rowspan="{{ $totalProjectActivities }}" class="nowrap"
                                        style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        {{ $project->project_nama }}
                                    </td>
                                @endif

                                <td class="nowrap" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                    {{ $scope->nama }}</td>

                                {{-- Activity data --}}
                                <td class="col-1" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                                <td class="col-2" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                                <td class="col-3" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                                <td class="col-4" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                                <td class="col-5" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                                <td class="col-6" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>

                                {{-- PICs --}}
                                <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>

                                <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>

                                @foreach ($months as $key => $month)
                                    @for ($i = 1; $i <= $month['weeks']; $i++)
                                        <td
                                            style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                        </td>
                                    @endfor
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td rowspan="1" class="nowrap"
                            style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                            {{ $project->project_nama }}
                        </td>

                        <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                        </td>
                        {{-- Activity data --}}
                        <td class="col-1" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>
                        <td class="col-2" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>
                        <td class="col-3" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>
                        <td class="col-4" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>
                        <td class="col-5" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>
                        <td class="col-6" style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>

                        {{-- PICs --}}
                        <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>

                        <td style="text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;"></td>

                        @foreach ($months as $key => $month)
                            @for ($i = 1; $i <= $month['weeks']; $i++)
                                <td style="width: 50px; text-align:center; font-size:9px; vertical-align:middle; word-wrap: break-word; width: 80px; overflow-wrap: break-word; white-space: normal;">
                                </td>
                            @endfor
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
