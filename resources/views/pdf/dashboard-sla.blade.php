<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard SLA</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h2>Dashboard SLA</h2>

    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Scope</th>
                <th>Activity</th>
                <th>Plan Start</th>
                <th>Plan Duration (Weeks)</th>
                <th>Actual Start</th>
                <th>Actual Duration</th>
                <th>% Complete</th>
                <th>PIC</th>
                <th>Rincian Progress</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                @php
                    $totalProjectActivities = $project->scopes->sum(function ($scope) {
                        return $scope->activities->count();
                    });
                @endphp
                {{-- Looping untuk setiap scope di dalam project --}}
                @foreach ($project->scopes as $scope)
                    @php
                        $totalScopeActivities = $scope->activities->count();
                    @endphp
                    {{-- Looping untuk setiap activity di dalam scope --}}
                    @foreach ($scope->activities as $activity)
                        <tr>
                            {{-- Project row rowspan --}}
                            @if ($loop->parent->first && $loop->first)
                                <td rowspan="{{ $totalProjectActivities }}">{{ $project->project_nama }}</td>
                            @endif

                            {{-- Scope row rowspan --}}
                            @if ($loop->first)
                                <td rowspan="{{ $totalScopeActivities }}">{{ $scope->nama }}</td>
                            @endif

                            {{-- Activity data --}}
                            <td>{{ $activity->nama_activity }}</td>
                            <td>{{ $activity->plan_start }}</td>
                            <td>{{ $activity->plan_duration }}</td>
                            <td>{{ $activity->actual_start }}</td>
                            <td>{{ $activity->actual_duration }}</td>
                            <td>{{ $activity->percent_complete }}%</td>

                            {{-- PICs --}}
                            <td>
                                @if ($activity->pics->isNotEmpty())
                                    @foreach ($activity->pics as $pic)
                                        {{ $pic->bagian->master_bagian_kode }} <br>
                                    @endforeach
                                @else
                                    &nbsp;
                                @endif
                            </td>

                            {{-- Detail Progress --}}
                            <td>
                                @if ($activity->progress->isNotEmpty())
                                    {{ $activity->progress->first()->rincian_progress }}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                @if ($loop->iteration == 8)
                    <div class="page-break"></div>
                @endif
            @endforeach
        </tbody>
    </table>

</body>

</html>
