<div class="row align-items-center mb-3">
    <div class="col-md-3">
        <h6 class="text-secondary">{{ $activity->nama_activity }}</h6>
    </div>
    <div class="col-md-9 d-flex align-items-center">
        <div class="progress" style="height: 25px; flex-grow: 1;">
            <div id="progress-bar-activity-1"
                class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated" role="progressbar"
                style="width: {{ $activity->percent_complete }}%;" data-activity-id="1"
                aria-valuenow="{{ $activity->percent_complete }}" aria-valuemin="0" aria-valuemax="100">
                {{ $activity->percent_complete }}%
            </div>
        </div>
        <span class="ml-2 font-weight-bold">100%</span>
    </div>
</div>
