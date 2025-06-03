<style>
    .progress-bar {
        transition: width 1.2s ease;
    }

    /* CSS animation for icon transition */
    .icon-transition {
        transition: transform 0.3s ease;
    }

    .icon-expand {
        transform: rotate(180deg);
    }

    .icon-collapse {
        transform: rotate(0deg);
    }
</style>

<div class="row align-items-center mb-3">
    <div class="col-md-12">
        <div class="card card-outline card-secondary collapsed-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex w-100 align-items-center">
                    <div class="col-md-3">
                        <h6 class="text-secondary font-weight-bold mb-0">{{ $scope->nama }}</h6>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <div class="progress" style="height: 25px; flex-grow: 1;">
                            <div id="progress-bar-{{ $scope->id }}"
                                class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated font-weight-bolder"
                                role="progressbar"
                                style="width: {{ $scope->percent_complete }}%;"
                                aria-valuenow="{{ $scope->percent_complete }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $scope->percent_complete }}%
                            </div>  
                        </div>
                        <span class="ml-2 font-weight-bold">100%</span>
                    </div>
                </div>
                <div class="card-tools">
                    <!-- Button to toggle activity details -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    @foreach ($scope->activities as $activity)
                        @php
                            $randomColor = $progressColors[array_rand($progressColors)];
                        @endphp
                        <x-sla.scope-activity :activity="$activity" :color="$randomColor" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-3">
        <h6 class="text-secondary">{{ $scope->nama }}</h6>
    </div>
    <div class="col-md-9 d-flex align-items-center">
        <div class="progress" style="height: 25px; flex-grow: 1;">
            <div id="progress-bar-{{ $scope->id }}"
                class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated" role="progressbar"
                style="width: 0%;" data-scope-id="{{ $scope->id }}" aria-valuenow="0" aria-valuemin="0"
                aria-valuemax="100">
                0%
            </div>
        </div>
        <span class="ml-2 font-weight-bold">100%</span>
        <!-- Button to toggle activity details -->
        <button class="btn btn-tool ml-3" type="button" data-toggle="collapse"
            data-target="#collapse-activity-{{ $scope->id }}"
            aria-controls="collapse-activity-{{ $scope->id }}">
            <i class="fas fa-plus icon-transition"></i>
        </button>
    </div> --}}
</div>



<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Toggle icon based on collapse state
        $('.collapse').on('show.bs.collapse', function() {
            var target = $(this).attr('id');
            $('button[data-target="#' + target + '"] i')
                .removeClass('fa-plus')
                .addClass('fa-minus')
                .addClass('icon-expand') // Add expand animation class
                .removeClass('icon-collapse'); // Remove collapse animation class
        });

        $('.collapse').on('hide.bs.collapse', function() {
            var target = $(this).attr('id');
            $('button[data-target="#' + target + '"] i')
                .removeClass('fa-minus')
                .addClass('fa-plus')
                .addClass('icon-collapse') // Add collapse animation class
                .removeClass('icon-expand'); // Remove expand animation class
        });
    });
</script>
