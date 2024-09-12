<style>
    .progress-bar {
        transition: width 1.2s ease;
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
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
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
