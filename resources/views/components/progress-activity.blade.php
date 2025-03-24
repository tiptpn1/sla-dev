<div class="col-md-12">
    <div class="card mt-4 mb-4 w-100">
        <div class="card-header bg-primary text-white">
            <h4 class="font-weight-bold">Progress Overview</h4>
        </div>
        <div class="card-body">
            <!-- Card for each project -->
            @foreach ($projects as $project)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex align-items-center bg-light">
                        <i class="fas fa-project-diagram mr-2 text-primary"></i>
                        <h5 class="font-weight-bold mb-0">{{ $project->project_nama }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($project->scopes as $scope)
                            @php
                                $randomColor = $progressColors[array_rand($progressColors)];
                            @endphp
                            <x-sla.project-scope :scope="$scope" :color="$randomColor" />
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
