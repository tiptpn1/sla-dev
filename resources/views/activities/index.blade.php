@extends('master/master')

@section('title', 'Activity Program Kerja')

@section('activity', 'active')

@push('css')
    <style>
        .progress-bar {
            transition: width 0.8s ease;
        }
    </style>
@endpush

@section('content')
    <section class="content">
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-default">
                            <div class="card-header">

                                {{-- Hak Akses Koordinator --}}
                                @if (in_array(session()->get('hak_akses_id'), [2, 9, 10]))
                                    <a href="{{ route('activities.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Activity
                                    </a>
                                @endif
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $segmentIndex = 0;
                                        @endphp

                                        @foreach ($projects as $project)
                                                                            @php
                                                                                $segmentAlpha = numberToAlpha($segmentIndex++);
                                                                            @endphp
                                                                            <x-activity.project-accordion :project="$project" :alphabet="$segmentAlpha" />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </section>
@endsection