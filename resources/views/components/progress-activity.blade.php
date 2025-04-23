<div class="col-md-12">
    <div class="card mt-4 mb-4 w-100">
        <div class="card-header bg-primary text-white">
            <h4 class="font-weight-bold">Progress Overview by Gantt Chart</h4>
        </div>
        <div class="card-body" id="gantt-chart-field">
            @if(count($projects) > 0)
                <div id="gantt_here" style="width:100%; height:500px;"></div>
            @else
                <div class="alert alert-info">
                    Tidak ada proyek yang tersedia untuk ditampilkan.
                </div>
            @endif

        </div>
    </div>
</div>