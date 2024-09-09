@extends('master/master')

@section('title', 'Sub Perspektif Data')

@section('subSegment', 'active')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-default mr-3">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSubSegmentModal">
                            Create Sub Perspektif
                        </button>
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-6">Name</th>
                                    <th class="col-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subSegments as $subSegment)
                                    <tr>
                                        <td>{{ ($subSegments->currentPage() - 1) * $subSegments->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $subSegment->kpi_master_data_kpi_subsegmen_judul }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#updateSubSegmentModal{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#deleteSubSegmentModal"
                                                data-id="{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}"
                                                data-name="{{ $subSegment->kpi_master_data_kpi_subsegmen_judul }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $subSegments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Sub Segment Modal --}}
        <div class="modal fade" id="createSubSegmentModal" tabindex="-1" role="dialog"
            aria-labelledby="createSubSegmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSubSegmentModalLabel">Create Sub-Perspektif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('sub-segment.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Sub Segment Modal --}}
        @foreach ($subSegments as $subSegment)
            <div class="modal fade" id="updateSubSegmentModal{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}"
                tabindex="-1" role="dialog"
                aria-labelledby="updateSubSegmentModalLabel{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="updateSubSegmentModalLabel{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}">Update
                                Sub-Perspektif</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('sub-segment.update', $subSegment->kpi_master_data_kpi_subsegmen_id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}">Name</label>
                                    <input type="text" class="form-control"
                                        id="name{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}" name="name"
                                        value="{{ $subSegment->kpi_master_data_kpi_subsegmen_judul }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Delete Sub Segment Modal --}}
        <div class="modal fade" id="deleteSubSegmentModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteSubSegmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSubSegmentModalLabel">Delete Sub-Perspektif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus data Sub-Perspektif <strong id="subSegmentName"></strong>?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Create Segment
            $('#createSegmentForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('segment.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createSegmentModal').modal('hide');
                        $('#segmentsTable tbody').append(`<tr id="segment-${response.id}">
                    <td>${response.id}</td>
                    <td>${response.name}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateSegmentModal${response.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-segment" data-id="${response.id}">Delete</button>
                    </td>
                </tr>`);
                        toastr.success('Perspektif created successfully!');
                    },
                    error: function(response) {
                        toastr.error('There was an error creating the Perspektif.');
                    }
                });
            });
        });

        $('#deleteSubSegmentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#subSegmentName').text(name);

            var form = modal.find('#deleteForm');
            form.attr('action', '/sub-segment/' + id);
        });
    </script>
@endpush
