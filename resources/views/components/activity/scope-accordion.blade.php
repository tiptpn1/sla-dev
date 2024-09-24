<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-secondary collapsed-card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ $scope->nama }}

                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <x-activity.activity-table :activities="$scope->activities" :id="$tableId" :scopeId="$scope->id" />
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
