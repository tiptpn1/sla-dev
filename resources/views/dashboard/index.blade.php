@extends('master/master')

@section('title', 'Dashboard SLA')

@section('dashboard', 'active')

@section('content')
    <section class="content">
        <x-progress-activity />

        <div class="col-md-12">
            <div class="card mt-4 mb-4 w-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="font-weight-bold">Progress Activity Overview by Gantt Chart</h4>
                </div>
                <div class="card-body" id="gantt-chart-field"></div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ route("ganchart") }}',
                method: 'GET',
                success: function (response) {
                    $('#gantt-chart-field').html(response);
                }
            });
        });
    </script>
@endsection
