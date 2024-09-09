@extends('master/master')

@section('title', 'Data Perspektif')

@section('segment', 'active')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-default mr-3">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSegmentModal">
                            Create Perspektif
                        </button>
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($segments as $segment)
                                    <tr>
                                        <td>{{ ($segments->currentPage() - 1) * $segments->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $segment->kpi_master_data_kpi_segmen_global }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#updateSegmentModal{{ $segment->kpi_master_data_kpi_segmen_id }}">Edit</button>

                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#deleteSegmentModal"
                                                data-id="{{ $segment->kpi_master_data_kpi_segmen_id }}"
                                                data-name="{{ $segment->kpi_master_data_kpi_segmen_global }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $segments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Segment Modal --}}
        <div class="modal fade" id="createSegmentModal" tabindex="-1" role="dialog"
            aria-labelledby="createSegmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSegmentModalLabel">Create Perspektif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('segment.store') }}" method="POST">
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

        {{-- Update Segment Modal --}}
        @foreach ($segments as $segment)
            <div class="modal fade" id="updateSegmentModal{{ $segment->kpi_master_data_kpi_segmen_id }}" tabindex="-1"
                role="dialog" aria-labelledby="updateSegmentModalLabel{{ $segment->kpi_master_data_kpi_segmen_id }}"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="updateSegmentModalLabel{{ $segment->kpi_master_data_kpi_segmen_id }}">Update Perspektif
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('segment.update', $segment->kpi_master_data_kpi_segmen_id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name{{ $segment->kpi_master_data_kpi_segmen_id }}">Name</label>
                                    <input type="text" class="form-control"
                                        id="name{{ $segment->kpi_master_data_kpi_segmen_id }}" name="name"
                                        value="{{ $segment->kpi_master_data_kpi_segmen_global }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Delete Sub Segment Modal --}}
        <div class="modal fade" id="deleteSegmentModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSegmentModalLabel">Delete Perspektif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus data Perspektif <strong id="segmentName"></strong>?
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
        $('#deleteSegmentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#segmentName').text(name);

            var form = modal.find('#deleteForm');
            form.attr('action', '/segment/' + id);
        });
    </script>
@endpush
