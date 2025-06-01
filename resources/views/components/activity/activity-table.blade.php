<div class="container">
    <table id="table_{{ $id }}" class="table_data table table-bordered table-responsive">
        <thead>
            <tr>
                <th>No.</th>
                <th>Activity</th>
                <th>Plan Start</th>
                <th>Plan Duration (Week)</th>
                <th>Plan End</th>
                <th>Actual Start</th>
                <th>Actual Duration (Week)</th>
                <th>Actual End</th>
                <th>Percent Complete</th>
                <th>PIC Project</th>
                <th>Rincian Progress</th>
                <th>Evidence</th>
                <th>Tanggal Rincian Progress</th>
                @if (session()->get('hak_akses_id') == 2)
                    <th>Status</th>
                @endif
                <th>Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                @php
                    $isPic = false; // Default: bukan PIC
                    $hakAksesIdUser = session()->get('hak_akses_id');

                    // Periksa apakah user yang login adalah PIC dari aktivitas ini
                    foreach ($activity->pics as $pic) {
                        if ( $hakAksesIdUser == 7) {                            $isPic = true;
                            break;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->nama_activity }}</td>
                    <td>
                        <input type="date" value="{{ $activity->plan_start }}"
                            class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                            data-id="{{ $activity->id_activity }}" data-field="plan_start" {{ $isPic ? '' : 'disabled' }}>
                    </td>
                    <td>
                        <input type="number" value="{{ $activity->plan_duration }}"
                            class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                            data-id="{{ $activity->id_activity }}" data-field="plan_duration" min="0"
                            step="1" {{ $isPic ? '' : 'disabled' }}>
                    </td>
                    <td id="plan-end-{{ $activity->id_activity }}">{{ $activity->plan_end }}</td>
                    <td>
                        <input type="date" value="{{ $activity->actual_start }}"
                            class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                            data-id="{{ $activity->id_activity }}" data-field="actual_start"
                            {{ $isPic ? '' : 'disabled' }}>
                    </td>
                    <td>
                        <input type="number" value="{{ $activity->actual_duration }}"
                            class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                            data-id="{{ $activity->id_activity }}" data-field="actual_duration" min="0"
                            step="1" {{ $isPic ? '' : 'disabled' }}>
                    </td>
                    <td id="actual-end-{{ $activity->id_activity }}">{{ $activity->actual_end }}</td>

                    <td>
                        <input type="number" value="{{ $activity->percent_complete }}"
                            class="edit form-control {{ $isPic ? 'bg-secondary text-white' : '' }}"
                            data-id="{{ $activity->id_activity }}" data-field="percent_complete"
                            data-scope-id="{{ $scopeId }}" min="0" max="100" step="0.01"
                            {{ $isPic ? '' : 'disabled' }}>
                    </td>
                    <td>
                        @if ($activity->pics->isNotEmpty())
                            @foreach ($activity->pics as $pic)
                                <span class="badge badge-primary"
                                    style="margin: 2px; padding: 5px 10px; background-color: #007bff; color: white; border-radius: 15px; cursor: pointer;"
                                    title="{{ $pic->bagian->master_bagian_nama }}">
                                    {{ $pic->bagian->master_bagian_kode }}
                                </span>
                            @endforeach
                        @else
                            <em>No PICs available</em>
                        @endif
                    </td>
                    <td>
                        @if ($activity->progress->isNotEmpty())
                            <div class="text-muted">
                                <span>...,</span>
                                <span class="font-weight-bold">
                                    {{ $activity->progress->first()->rincian_progress }}
                                </span>
                            </div>
                        @else
                            <em class="text-danger">No Progress available</em>
                        @endif
                    </td>
                    <td>
                        @if ($activity->progress->isNotEmpty() && $activity->progress->first()->evidences->isNotEmpty())
                            <div class="text-muted">
                                <span>...,</span>
                                <a href="{{ $activity->progress->first()->evidences->first()->file_path }}"
                                    target="_blank" class="text-info">
                                    {{-- Tambahkan icon file menggunakan Font Awesome --}}
                                    <i class="fas fa-file-alt"></i>
                                    {{ $activity->progress->first()->evidences->first()->file_path }}
                                </a>
                            </div>
                        @else
                            <em class="text-danger">No Evidence available</em>
                        @endif
                    </td>
                    <td>
                        @if ($activity->progress->isNotEmpty())
                            <div class="text-muted">
                                <span class="font-weight-bold">
                                    {{ $activity->progress->first()->tanggal }}
                                </span>
                            </div>
                        @else
                            <em class="text-danger">No date available</em>
                        @endif
                    </td>
                    @if (session()->get('hak_akses_id') == 2)
                        <td>
                            @if ($activity->isActive)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    @endif

                    <td>
                        @if ($isPic || session()->get('hak_akses_id') == 3)
                            <a href="{{ route('rincian.show', ['id' => $activity->id_activity]) }}"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                                Show
                            </a>
                        @endif

                        @if (in_array(session()->get('hak_akses_id'), [1, 2, 9, 10]))
                            <a href="{{ route('activities.edit', $activity->id_activity) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a href="javascript:void(0)" onclick="deleteActivity({{ $activity->id_activity }})"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                            <button class="btn btn-primary btn-sm status-btn" data-id="{{ $activity->id_activity }}"
                                data-status="{{ $activity->isActive ? 0 : 1 }}">
                                <i class="fas fa-power-off"></i>
                                {{ $activity->isActive ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
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
            var scopeId = null;

            if (field == 'percent_complete') {
                scopeId = $(this).data('scope-id');
                console.log(scopeId);

                if (value.startsWith('0')) {
                    value = value.replace(/^0+/, ''); // Remove leading zeros
                    $(this).val(value); // Update the input with the new value
                }
            }

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
                    $('#plan-end-' + id).text(response.data.plan_end);
                    $('#actual-end-' + id).text(response.data.actual_end);
                    toastr.success(response.message);
                    if (scopeId != null) {
                        updateProgressBar(scopeId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        })

        $('.status-btn').on('click', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var button = $(this);

            // Konfirmasi sebelum melanjutkan
            Swal.fire({
                title: 'Are you sure?',
                text: status ? 'Activate this activity?' : 'Deactivate this activity?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('activity.status', ':id') }}".replace(':id',
                            id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "PATCH",
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            // Update tombol status dan badge status tanpa reload
                            var badge = button.closest('tr').find(
                                'td:eq(10) span'); // Cari badge status

                            if (status == 1) {
                                badge.removeClass('badge-danger').addClass(
                                    'badge-success').text('Active');
                                button.data('status', 0); // Update status button
                                button.html(
                                    '<i class="fas fa-power-off"></i> Nonaktifkan'
                                );
                            } else {
                                badge.removeClass('badge-success').addClass(
                                    'badge-danger').text('Inactive');
                                button.data('status', 1); // Update status button
                                button.html(
                                    '<i class="fas fa-power-off"></i> Aktifkan');
                            }

                            toastr.success(response.message);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            toastr.error(response.message);
                        }
                    });
                }
            })
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
