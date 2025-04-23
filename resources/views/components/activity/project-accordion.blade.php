<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-secondary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">{{ $alphabet }}.
                        {{ $project->project_nama }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @foreach ($project->scopes as $scope)
                        @php
                            $tableId = $alphabet . $loop->iteration;
                        @endphp
                        <x-activity.scope-accordion :scope="$scope" :tableId="$tableId" />
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
