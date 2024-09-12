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
    <div class="col-md-3">
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
            data-target="#collapse-activity-{{ $scope->id }}" aria-controls="collapse-activity-{{ $scope->id }}">
            <i class="fas fa-plus icon-transition"></i>
        </button>
    </div>
</div>

<!-- Activity details collapse -->
<div id="collapse-activity-{{ $scope->id }}" class="collapse" aria-labelledby="heading-{{ $scope->id }}">
    <div class="card-body">
        @foreach ($scope->activities as $activity)
            @php
                $randomColor = $progressColors[array_rand($progressColors)];
            @endphp
            <x-sla.scope-activity :activity="$activity" :color="$randomColor" />
        @endforeach
    </div>
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

    var id = {{ $scope->id }};

    updateProgressBar(id);

    function updateProgressBar(scopeId) {
        $.ajax({
            url: "{{ route('master-scope.get-process', ':id') }}".replace(':id', scopeId),
            method: 'GET',
            success: function(response) {
                const percentComplete = parseFloat(response.percent_complete).toFixed(2);

                // Update the corresponding progress bar width and text
                $('#progress-bar-' + scopeId)
                    .css('width', percentComplete + '%')
                    .attr('aria-valuenow', percentComplete)
                    .text(percentComplete + '%');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching progress:', error);
            }
        });
    }
</script>
