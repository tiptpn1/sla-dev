 @php
    $isPic = false; // Default: bukan PIC
    $hakAksesIdUser = session()->get('hak_akses_id');

    // Periksa apakah user yang login adalah PIC dari aktivitas ini
    foreach ($activity->pics as $pic) {
        if ( $hakAksesIdUser == 7) {                            
            $isPic = true;
            break;
        }
    }
@endphp

<div class="row align-items-center mb-3">
    <div class="col-md-3 d-flex justify-content-between align-items-center">
        <h6 class="text-secondary mb-0">{{ $activity->nama_activity }}</h6>
        @if ($isPic || session('hak_akses_id') == 3)
            <a href="{{ route('rincian.show', ['id' => $activity->id_activity]) }}" class="btn btn-info btn-sm ml-2">
                <i class="fas fa-eye"></i>
                Show
            </a>
        @endif
    </div>
    <div class="col-md-9 d-flex align-items-center">
        <div class="progress" style="height: 25px; flex-grow: 1;">
            <div id="progress-bar-activity-1"
                class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated font-weight-bold"
                role="progressbar" style="width: {{ $activity->percent_complete }}%;" data-activity-id="1"
                aria-valuenow="{{ $activity->percent_complete }}" aria-valuemin="0" aria-valuemax="100">
                {{ $activity->percent_complete }}%
            </div>  
        </div>
        <span class="ml-2 font-weight-bold">100%</span>
    </div>
</div>
