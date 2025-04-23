@extends('master/master')

@section('title', 'Edit Activity')

@section('activity', 'active')

@push('css')
    <style>
        /* Styling untuk setiap tag yang dipilih */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1E88E5 !important;
            border: 1px solid #0D47A1 !important;
            color: white !important;
            padding: 3px 10px !important;
            margin: 3px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
            color: black !important;
            margin-left: 10px !important;
            cursor: pointer !important;
            font-weight: bold !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Activity</div>

                    <div class="card-body">
                        <form action="{{ route('activities.update', $activity->id_activity) }}" method="POST"
                            id="update-activity-form">
                            @csrf
                            @method('PUT')

                            <!-- Project Dropdown -->
                            <div class="form-group">
                                {{-- @dd(session()->get('hak_akses_id')) --}}
                                <label for="project_id">Project</label>
                                <select name="project_id" class="form-control @error('project_id') is-invalid @enderror"
                                    id="project_id" {{ session()->get('hak_akses_id') == 2 ? 'required' : 'disabled' }}>
                                    <option value="{{ $activity->project_id }}" selected>
                                        {{ $activity->proyek->project_nama }}
                                    </option>
                                </select>
                                @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Scope Dropdown -->
                            <div class="form-group">
                                <label for="scope_id">Scope</label>
                                <select name="scope_id" class="form-control @error('scope_id') is-invalid @enderror"
                                    id="scope_id" {{ session()->get('hak_akses_id') == 2 ? 'required' : 'disabled' }}>
                                    <option value="{{ $activity->scope_id }}" selected>
                                        {{ $activity->scope->nama }}
                                    </option>
                                </select>
                                @error('scope_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Nama Activity -->
                            <div class="form-group">
                                <label for="nama_activity">Nama Activity</label>
                                <input type="text" name="nama_activity"
                                    class="form-control @error('nama_activity') is-invalid @enderror" id="nama_activity"
                                    value="{{ old('nama_activity', $activity->nama_activity) }}"
                                    {{ session()->get('hak_akses_id') == 2 ? 'required' : 'disabled' }}>
                                @error('nama_activity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Plan Start Date -->
                            <div class="form-group" {{ $hasAccess ? '' : 'hidden' }}>
                                <label for="plan_start">Plan Start Date</label>
                                <input type="date" name="plan_start"
                                    class="form-control @error('plan_start') is-invalid @enderror" id="plan_start"
                                    value="{{ old('plan_start', $activity->plan_start) }}"
                                    {{ $hasAccess ? 'required' : 'readonly' }}>
                                @error('plan_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Plan Duration -->
                            <div class="form-group" {{ $hasAccess ? '' : 'hidden' }}>
                                <label for="plan_duration">Plan Duration (days)</label>
                                <input type="number" name="plan_duration"
                                    class="form-control @error('plan_duration') is-invalid @enderror" id="plan_duration"
                                    value="{{ old('plan_duration', $activity->plan_duration) }}"
                                    {{ $hasAccess ? 'required' : 'readonly' }}>
                                @error('plan_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Actual Start Date (Optional) -->
                            <div class="form-group" {{ $hasAccess ? '' : 'hidden' }}>
                                <label for="actual_start">Actual Start Date (optional)</label>
                                <input type="date" name="actual_start"
                                    class="form-control @error('actual_start') is-invalid @enderror" id="actual_start"
                                    value="{{ old('actual_start', $activity->actual_start) }}"
                                    {{ $hasAccess ? 'required' : 'readonly' }}>
                                @error('actual_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Actual Duration (Optional) -->
                            <div class="form-group" {{ $hasAccess ? '' : 'hidden' }}>
                                <label for="actual_duration">Actual Duration (days, optional)</label>
                                <input type="number" name="actual_duration"
                                    class="form-control @error('actual_duration') is-invalid @enderror" id="actual_duration"
                                    value="{{ old('actual_duration', $activity->actual_duration) }}"
                                    {{ $hasAccess ? 'required' : 'readonly' }}>
                                @error('actual_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Percent Complete (Optional) -->
                            <div class="form-group" {{ $hasAccess ? '' : 'hidden' }}>
                                <label for="percent_complete">Percent Complete (%)</label>
                                <input type="number" name="percent_complete"
                                    class="form-control @error('percent_complete') is-invalid @enderror"
                                    id="percent_complete"
                                    value="{{ old('percent_complete', $activity->percent_complete) }}"
                                    {{ $hasAccess ? 'required' : 'readonly' }}>
                                @error('percent_complete')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Select PIC (Multiple Selection with Select2) -->
                            <div class="form-group">
                                <label for="bagian_id">Select PIC(s)</label>
                                <select name="bagian_id[]"
                                    class="form-control select2 @error('bagian_id') is-invalid @enderror" id="bagian_id"
                                    multiple {{ session()->get('hak_akses_id') == 2 ? 'required' : 'disabled' }}>
                                    @foreach ($bagians as $bagian)
                                        <option value="{{ $bagian->master_bagian_id }}"
                                            {{ in_array($bagian->master_bagian_id, old('bagian_id', $activity->pics->pluck('bagian_id')->toArray())) ? 'selected' : '' }}>
                                            {{ $bagian->master_bagian_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bagian_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update Activity</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#bagian_id').select2({
                placeholder: 'Select PIC(s)',
                allowClear: true
            });

            $('#project_id').select2({
                placeholder: 'Select Project',
                width: '100%',
                ajax: {
                    url: "{{ route('project.data') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term, // Istilah pencarian
                            page: params.page || 1 // Halaman yang akan diminta
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.result, function(item) {
                                return {
                                    text: item.project_nama,
                                    id: item.id_project
                                }
                            }),
                            pagination: {
                                more: data.incomplete_results
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#project_id').on('change', function() {
                let id = $('#project_id').val();

                $('#scope_id').empty();

                $('#scope_id').select2({
                    placeholder: 'Select Scope',
                    width: '100%',
                    ajax: {
                        url: "{{ url('scope') }}/" + id + "/data",
                        dataType: 'json',
                        data: function(params) {
                            return {
                                q: params.term, // Istilah pencarian
                                page: params.page || 1 // Halaman yang akan diminta
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data.result, function(item) {
                                    return {
                                        text: item.nama,
                                        id: item.id
                                    }
                                }),
                                pagination: {
                                    more: data.incomplete_results
                                }
                            };
                        },
                        cache: true
                    }
                });
            })

            $('form#update-activity-form').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update this activity?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        $(this).off('submit').submit();
                    }
                });
            });
        });
    </script>
@endpush
