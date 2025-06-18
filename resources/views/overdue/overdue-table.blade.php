
<table id="{{ $id }}" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Activity</th>
            <th>Progress</th>
            <th>Deadline</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($overdue as $index => $activity)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $activity->nama_activity }}</td>
                <td>{{ $activity->progress }}%</td>
                <td>{{ $activity->deadline }}</td>
                <td>
                    @if($activity->progress < 100 && \Carbon\Carbon::parse($activity->deadline)->isPast())
                        <span class="badge badge-danger">Overdue</span>
                    @else
                        <span class="badge badge-success">On Track</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
