@extends('master/master')

@section('title', 'Data KPI')

@section('kpi', 'active')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-default mr-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap mb-2">
                            <div class="mb-2">
                                <p>Page <span id="current-page"></span> of <span id="last-page"></span> | Total data: <span
                                        id="total-data"></span></p>
                            </div>
                            <a href="{{ route('kpi.create') }}" type="button" class="btn btn-primary mb-2">
                                Create KPI
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="kpi-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>formula</th>
                                        <th>Perspektif</th>
                                        <th>Sub-Perspektif</th>
                                        <th>Tahun</th>
                                        <th>ESG</th>
                                        <th>PS</th>
                                        <th>Satuan</th>
                                        <th>Polaritas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination" id="pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data KPI ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            loadKPIData(1);

            function loadKPIData(page) {
                $.ajax({
                    url: '{{ route('kpi.data') }}',
                    method: 'GET',
                    data: {
                        page: page
                    },
                    success: function(data) {
                        $('#kpi-table tbody').empty();
                        $.each(data.data, function(index, kpi) {
                            var urlShow = "{{ route('kpi.show', ':Id') }}".replace(':Id', kpi
                                .kpi_master_data_kpi_id);
                            var urlEdit = "{{ route('kpi.edit', ':Id') }}".replace(':Id', kpi
                                .kpi_master_data_kpi_id);
                            var row = '<tr id="kpi-' + kpi.kpi_master_data_kpi_id + '">' +
                                '<td>' + ((data.pagination.current_page - 1) * data.pagination
                                    .per_page + index + 1) + '</td>' +
                                '<td>' + kpi.kpi_master_data_kpi_nama + '</td>' +
                                '<td>' + kpi.kpi_master_data_kpi_formula + '</td>' +
                                '<td>' + kpi.segmen_global + '</td>' +
                                '<td>' + kpi.subsegmen_judul + '</td>' +
                                '<td>' + kpi.kpi_master_data_kpi_tahun + '</td>' +
                                '<td>' + kpi.kpi_master_data_kpi_esg + '</td>' +
                                '<td>' + (kpi.kpi_master_data_kpi_ps ?? '') + '</td>' +
                                '<td>' + (
                                    kpi.kpi_satuan_nama ?? ''
                                ) + '</td>' +
                                '<td>' + kpi.kpi_master_data_kpi_polaritas + '</td>' +
                                '<td>' +
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<a class="btn btn-sm btn-primary" href="' + urlShow +
                                '">Show</a>' +
                                '<a class="btn btn-sm btn-warning" href="' + urlEdit +
                                '">Edit</a>' +
                                '<button class="btn btn-sm btn-danger deleteButton" type="button" data-toggle="modal" data-id="' +
                                kpi.kpi_master_data_kpi_id + '" data-page="' + data.pagination
                                .current_page + '">Delete</button>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                            $('#kpi-table tbody').append(row);
                        });

                        $('#pagination').empty();
                        $('#current-page').text(data.pagination.current_page);
                        $('#last-page').text(data.pagination.last_page);
                        $('#total-data').text(data.pagination.total);

                        if (data.pagination.current_page > 1) {
                            $('#pagination').append(
                                '<li class="page-item"><a class="page-link" href="#" data-page="' +
                                (data.pagination.current_page - 1) + '">Previous</a></li>');
                        }

                        for (var i = 1; i <= data.pagination.last_page; i++) {
                            var activeClass = (i === data.pagination.current_page) ? 'active' : '';
                            $('#pagination').append('<li class="page-item ' + activeClass +
                                '"><a class="page-link" href="#" data-page="' + i + '">' + i +
                                '</a></li>');
                        }

                        if (data.pagination.current_page < data.pagination.last_page) {
                            $('#pagination').append(
                                '<li class="page-item"><a class="page-link" href="#" data-page="' +
                                (data.pagination.current_page + 1) + '">Next</a></li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Failed to load data.');
                    }
                });
            }

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadKPIData(page);
            });

            $(document).on('click', '.deleteButton', function() {
                var itemId = $(this).data('id');
                deleteUrl = `{{ route('kpi.destroy', ['id' => ':Id']) }}`.replace(':Id', itemId);
                deleteRow = `#kpi-${itemId}`;
                cPage = $(this).data('page');
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').click(function() {
                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(deleteRow).remove();
                        $('#deleteModal').modal('hide');
                        toastr.success('KPI deleted successfully.');
                        loadKPIData(cPage);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        toastr.error('Failed to delete KPI.');
                        $('#deleteModal').modal('hide');
                    }
                });
            });
        });
    </script>
@endpush
