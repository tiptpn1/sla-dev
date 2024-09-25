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
    @php
        use Carbon\Carbon;

        function countWeeksStartDays(Carbon $date, $month)
        {
            $currentDate = $date->copy();

            $dateNow = $currentDate->format('d');
            $monthNow = intval($currentDate->format('m'));

            $startDate = $date->modify('first day of this month');
            $startDays = $startDate->format('N');

            $totalWeeksInYear = 0;
            for ($i = 1; $i < $monthNow; $i++) {
                $totalWeeksInYear += $month[$i]['weeks'];
            }

            $weekNow = intval(ceil(($dateNow + ($startDays - 1)) / 7));

            return $weekNow + $totalWeeksInYear;
        }
    @endphp

    <h2>Dashboard SLA</h2>

    <table>
        <thead>
            <tr>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Project</th>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Scope</th>
                <th rowspan="3" class="col-1"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Activity</th>
                <th rowspan="3" class="col-2"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Plan Start</th>
                <th rowspan="3" class="col-3"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Plan Duration (Weeks)</th>
                <th rowspan="3" class="col-4"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Actual Start</th>
                <th rowspan="3" class="col-5"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Actual Duration</th>
                <th rowspan="3" class="col-6"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    % Complete</th>
                <th rowspan="3" class="col-7"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    PIC</th>
                <th rowspan="3" class="col-8"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    Rincian Progress</th>
                <th colspan="{{ $countWeeks }}" class="col-9"
                    style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                    {{ $year }}</th>
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    <th colspan="{{ $month['weeks'] }}"
                        style="text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                        {{ $month['month'] }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($months as $key => $month)
                    @for ($i = 1; $i <= $month['weeks']; $i++)
                        <th
                            style="width: 60px; text-align:center; font-weight:bold; font-size:11px; vertical-align:middle; background-color:#007BFF; color:#FFFFFF; border:1px solid #FFFFFF">
                            Week {{ $i }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                @php
                    $totalProjectActivities = $project->scopes->sum(function ($scope) {
                        if (count($scope->activities)) {
                            return $scope->activities->count();
                        } else {
                            return 1;
                        }
                    });

                    $headerProject = true;
                @endphp
                @if (count($project->scopes))
                    @foreach ($project->scopes as $scope)
                        @php
                            $headerScope = true;
                        @endphp
                        @if (count($scope->activities))
                            @php
                                $totalScopeActivities = $scope->activities->count();
                            @endphp
                            @foreach ($scope->activities as $activity)
                                @php
                                    $plan_start = '';
                                    $plan_end = '';
                                    $actual_start = '';
                                    $actual_end = '';
                                    $week_no = 0;

                                    if ($activity->plan_start && $activity->plan_duration) {
                                        $plan_start = (Carbon::parse($activity->plan_start))->format('N') != 1? countWeeksStartDays((Carbon::parse($activity->plan_start))->modify("Last Monday"), $months) : countWeeksStartDays(Carbon::parse($activity->plan_start), $months);
                                        $plan_duration = $activity->plan_duration - 1;
                                        $plan_end = (Carbon::parse($activity->plan_start))->format('N') != 7? countWeeksStartDays((Carbon::parse($activity->plan_start))->modify("+{$plan_duration} weeks")->modify('This Sunday'), $months) : countWeeksStartDays((Carbon::parse($activity->plan_start))->modify("+{$plan_duration} weeks"), $months);
                                    }

                                    if ($activity->actual_start && $activity->actual_duration) {
                                        $actual_start = (Carbon::parse($activity->actual_start))->format('N') != 1? countWeeksStartDays((Carbon::parse($activity->actual_start))->modify("Last Monday"), $months) : countWeeksStartDays(Carbon::parse($activity->actual_start), $months);
                                        $actual_duration = $activity->actual_duration - 1;
                                        $actual_end = (Carbon::parse($activity->actual_start))->format('N') != 7? countWeeksStartDays((Carbon::parse($activity->actual_start))->modify("+{$actual_duration} weeks")->modify('Next Sunday'), $months) : countWeeksStartDays((Carbon::parse($activity->actual_start))->modify("+{$actual_duration} weeks"), $months);
                                    }

                                @endphp
                                <tr>
                                    {{-- Project rowspan --}}
                                    @if ($headerProject)
                                        @php
                                            $headerProject = false;
                                        @endphp
                                        <td rowspan="{{ $totalProjectActivities }}" class="nowrap"
                                            style="text-align:center; font-size:10px; vertical-align:middle;">
                                            {{ $project->project_nama }}
                                        </td>
                                    @endif

                                    {{-- Scope rowspan --}}
                                    @if ($headerScope)
                                        @php
                                            $headerScope = false;
                                        @endphp
                                        <td rowspan="{{ $totalScopeActivities }}" class="nowrap"
                                            style="text-align:center; font-size:10px; vertical-align:middle;">
                                            {{ $scope->nama }}</td>
                                    @endif

                                    {{-- Activity data --}}
                                    <td class="col-1"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->nama_activity }}</td>
                                    <td class="col-2"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->plan_start }}</td>
                                    <td class="col-3"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->plan_duration }}</td>
                                    <td class="col-4"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->actual_start }}</td>
                                    <td class="col-5"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->actual_duration }}</td>
                                    <td class="col-6"
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $activity->percent_complete }}%</td>

                                    {{-- PICs --}}
                                    <td style="text-align:center; font-size:10px; vertical-align:middle;">
                                        @php
                                            $pics = [];
                                            foreach ($activity->pics as $pic) {
                                                array_push($pics, $pic->bagian->master_bagian_kode);
                                            }
                                        @endphp
                                        {{ implode(', ', $pics) }}
                                    </td>

                                    <td style="text-align:center; font-size:10px; vertical-align:middle;">
                                        @if ($activity->progress->isNotEmpty())
                                            {{ $activity->progress->first()->nama }}
                                        @endif
                                    </td>

                                    @foreach ($months as $key => $month)
                                        @for ($i = 1; $i <= $month['weeks']; $i++)
                                            @php
                                                $week_no++;
                                            @endphp
                                            <td
                                                style="width: 50px; text-align:center; font-size:10px; vertical-align:middle; {{ ($week_no >= $plan_start && $week_no <= $plan_end) && ($week_no >= $actual_start && $week_no <= $actual_end)? 'background-color: #24A0E4;' : ($week_no >= $plan_start && $week_no <= $plan_end? 'background-color:#007BFF;' : ($week_no >= $actual_start && $week_no <= $actual_end? 'background-color: #8AD0BF;' : '')) }}"></td>
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
                                        style="text-align:center; font-size:10px; vertical-align:middle;">
                                        {{ $project->project_nama }}
                                    </td>
                                @endif

                                <td class="nowrap" style="text-align:center; font-size:10px; vertical-align:middle;">
                                    {{ $scope->nama }}</td>

                                {{-- Activity data --}}
                                <td class="col-1" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>
                                <td class="col-2" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>
                                <td class="col-3" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>
                                <td class="col-4" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>
                                <td class="col-5" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>
                                <td class="col-6" style="text-align:center; font-size:10px; vertical-align:middle;">
                                </td>

                                {{-- PICs --}}
                                <td style="text-align:center; font-size:10px; vertical-align:middle;"></td>

                                <td style="text-align:center; font-size:10px; vertical-align:middle;"></td>

                                @foreach ($months as $key => $month)
                                    @for ($i = 1; $i <= $month['weeks']; $i++)
                                        <td
                                            style="width: 50px; text-align:center; font-size:10px; vertical-align:middle;">
                                        </td>
                                    @endfor
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        {{-- Project rowspan --}}
                        <td class="nowrap"
                            style="text-align:center; font-size:10px; vertical-align:middle;">
                            {{ $project->project_nama }}
                        </td>

                        <td class="nowrap"
                            style="text-align:center; font-size:10px; vertical-align:middle;">
                        </td>

                        {{-- Activity data --}}
                        <td class="col-1" style="text-align:center; font-size:10px; vertical-align:middle;"></td>
                        <td class="col-2" style="text-align:center; font-size:10px; vertical-align:middle;"></td>
                        <td class="col-3" style="text-align:center; font-size:10px; vertical-align:middle;"></td>
                        <td class="col-4" style="text-align:center; font-size:10px; vertical-align:middle;"></td>
                        <td class="col-5" style="text-align:center; font-size:10px; vertical-align:middle;"></td>
                        <td class="col-6" style="text-align:center; font-size:10px; vertical-align:middle;"></td>

                        {{-- PICs --}}
                        <td style="text-align:center; font-size:10px; vertical-align:middle;"></td>

                        <td style="text-align:center; font-size:10px; vertical-align:middle;"></td>

                        @foreach ($months as $key => $month)
                            @for ($i = 1; $i <= $month['weeks']; $i++)
                                <td style="width: 50px; text-align:center; font-size:10px; vertical-align:middle;">
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
