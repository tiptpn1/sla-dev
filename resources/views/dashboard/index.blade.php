@extends('master/master')

@section('title', 'Dashboard SLA')

@section('dashboard', 'active')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-default">
                            <div class="card-header">

                                {{-- Hak Akses Koordinator --}}
                                @if (session()->get('hak_akses_id') == 2)
                                    <a href="{{ route('activities.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah Aktivitas
                                    </a>
                                @endif

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
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
                                                $subSegmentIndex = 1;
                                            @endphp
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-outline card-secondary collapsed-card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">{{ $segmentAlpha }}.
                                                                    {{ $project->project_nama }}</h3>

                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="maximize">
                                                                        <i class="fas fa-expand"></i>
                                                                    </button>
                                                                </div>
                                                                <!-- /.card-tools -->
                                                            </div>
                                                            <!-- /.card-header -->
                                                            <div class="card-body">
                                                                @foreach ($project->scopes as $scope)
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div
                                                                                class="card card-outline card-secondary collapsed-card">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">
                                                                                        {{ $segmentAlpha }}.{{ $subSegmentIndex }}.
                                                                                        {{ $scope->nama }}
                                                                                    </h3>

                                                                                    <div class="card-tools">
                                                                                        <button type="button"
                                                                                            class="btn btn-tool"
                                                                                            data-card-widget="collapse">
                                                                                            <i class="fas fa-plus"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <!-- /.card-tools -->
                                                                                </div>
                                                                                <!-- /.card-header -->
                                                                                <div class="card-body">
                                                                                    <div class="container">
                                                                                        <table id="table_a1"
                                                                                            class="table_data table table-bordered table-responsive">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>No.</th>
                                                                                                    <th>Activity</th>
                                                                                                    <th>Plan Start</th>
                                                                                                    <th>Plan Duration</th>
                                                                                                    <th>Actual Start</th>
                                                                                                    <th>Actual Duration</th>
                                                                                                    <th>Percent Complete
                                                                                                    </th>
                                                                                                    <th>PIC</th>
                                                                                                    <th>Action
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach ($scope->activities as $activity)
                                                                                                    @php
                                                                                                        $isPic = false; // Default: bukan PIC
                                                                                                        $bagianIdUser = session()->get(
                                                                                                            'bagian_id',
                                                                                                        ); // Dapatkan ID user yang sedang login

                                                                                                        // Periksa apakah user yang login adalah PIC dari aktivitas ini
                                                                                                        foreach (
                                                                                                            $activity->pics
                                                                                                            as $pic
                                                                                                        ) {
                                                                                                            if (
                                                                                                                $pic->bagian_id ==
                                                                                                                $bagianIdUser
                                                                                                            ) {
                                                                                                                $isPic = true;
                                                                                                                break;
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <tr>
                                                                                                        <td>{{ $loop->iteration }}
                                                                                                        </td>
                                                                                                        <td>{{ $activity->nama_activity }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="date"
                                                                                                                value="{{ $activity->plan_start }}"
                                                                                                                class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                                                                                                                data-id="{{ $activity->id_activity }}"
                                                                                                                data-field="plan_start"
                                                                                                                {{ $isPic ? '' : 'disabled' }}>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                value="{{ $activity->plan_duration }}"
                                                                                                                class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                                                                                                                data-id="{{ $activity->id_activity }}"
                                                                                                                data-field="plan_duration"
                                                                                                                min="0"
                                                                                                                step="1"
                                                                                                                {{ $isPic ? '' : 'disabled' }}>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="date"
                                                                                                                value="{{ $activity->actual_start }}"
                                                                                                                class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                                                                                                                data-id="{{ $activity->id_activity }}"
                                                                                                                data-field="actual_start"
                                                                                                                {{ $isPic ? '' : 'disabled' }}>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                value="{{ $activity->actual_duration }}"
                                                                                                                class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                                                                                                                data-id="{{ $activity->id_activity }}"
                                                                                                                data-field="actual_duration"
                                                                                                                min="0"
                                                                                                                step="1"
                                                                                                                {{ $isPic ? '' : 'disabled' }}>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                value="{{ $activity->percent_complete }}"
                                                                                                                class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                                                                                                                data-id="{{ $activity->id_activity }}"
                                                                                                                data-field="percent_complete"
                                                                                                                min="0"
                                                                                                                max="100"
                                                                                                                step="0.01"
                                                                                                                {{ $isPic ? '' : 'disabled' }}>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            @if ($activity->pics->isNotEmpty())
                                                                                                                @foreach ($activity->pics as $pic)
                                                                                                                    <span
                                                                                                                        class="badge badge-primary"
                                                                                                                        style="margin: 2px; padding: 5px 10px; display: inline-block; background-color: #007bff; color: white; border-radius: 15px; cursor: pointer;"
                                                                                                                        title="{{ $pic->bagian->master_bagian_nama }}">
                                                                                                                        {{ $pic->bagian->master_bagian_nama }}
                                                                                                                    </span>
                                                                                                                @endforeach
                                                                                                            @else
                                                                                                                <em>No PICs
                                                                                                                    available</em>
                                                                                                            @endif
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            @if ($isPic)
                                                                                                                <a href="{{ route('rincian.show', ['id' => $activity->id_activity]) }}"
                                                                                                                    class="btn btn-info btn-sm">Show</a>
                                                                                                            @endif

                                                                                                            @if (in_array(session()->get('hak_akses_id'), [1, 2]))
                                                                                                                <a href="{{ route('activities.edit', $activity->id_activity) }}"
                                                                                                                    class="btn btn-warning btn-sm">Edit</a>
                                                                                                                '<a href="javascript:void(0)"
                                                                                                                    onclick="deleteActivity({{ $activity->id_activity }})"
                                                                                                                    class="btn btn-danger btn-sm">Delete</a>'
                                                                                                            @endif
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.card-body -->
                                                                            </div>
                                                                            <!-- /.card -->
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                            </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('keypress', '.edit[data-field="plan_duration"], .edit[data-field="actual_duration"]',
                function(event) {
                    var charCode = event.which ? event.which : event.keyCode;
                    var inputValue = $(this).val();
                    // Izinkan angka (48-57), satu titik desimal (46), dan satu koma (44)
                    if ((charCode < 48 || charCode > 57) && charCode !== 46 && charCode !== 44) {
                        event.preventDefault();
                    }

                    // Hanya izinkan satu titik desimal atau satu koma
                    if ((charCode === 46 || charCode === 44) && (inputValue.indexOf('.') !== -1 || inputValue
                            .indexOf(',') !== -1)) {
                        event.preventDefault();
                    }
                });

            $(document).on('keypress', '.edit[data-field="percent_complete"]', function(event) {
                var charCode = event.which ? event.which : event.keyCode;
                var inputValue = $(this).val();
                // Izinkan angka (48-57), satu titik desimal (46), dan satu koma (44)
                if ((charCode < 48 || charCode > 57) && charCode !== 46 && charCode !== 44) {
                    event.preventDefault();
                }

                // Hanya izinkan satu titik desimal atau satu koma
                if ((charCode === 46 || charCode === 44) && (inputValue.indexOf('.') !== -1 || inputValue
                        .indexOf(',') !== -1)) {
                    event.preventDefault();
                }
            });

            $(document).on('input', '.edit[data-field="percent_complete"]', function() {
                var inputValue = $(this).val();

                // Ganti koma menjadi titik untuk penanganan desimal
                inputValue = inputValue.replace(',', '.');

                // Pastikan hanya bisa menginput angka 0-100
                if (parseFloat(inputValue) > 100) {
                    $(this).val(100);
                } else if (parseFloat(inputValue) < 0) {
                    $(this).val(0);
                } else if (inputValue === '') {
                    $(this).val(0);
                }
            });

            $('.edit').on('change', function() {
                var id = $(this).data('id');
                var field = $(this).data('field');
                var value = $(this).val().trim();

                $.ajax({
                    url: "{{ route('activity.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        field: field,
                        value: value
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error(response.message);
                    }
                });
            })
        });

        function deleteActivity(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('activities.destroy', ':id') }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The activity has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the activity.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush
