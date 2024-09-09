@extends('master/master')

@section('title', 'Data Master Bagian')

@section('master-bagian', 'active')

@push('css')
    <style>
        .btn-edit {
            background-color: transparent !important;
            /* Membuat latar belakang transparan */
            border: none !important;
            /* Menghilangkan border */
            color: #ffa500 !important;
            /* Warna oranye untuk 'Edit' */
        }

        .btn-edit:hover {
            color: #cc8400 !important;
            /* Warna oranye gelap saat hover */
        }

        .btn-delete {
            background-color: transparent !important;
            /* Membuat latar belakang transparan */
            border: none !important;
            /* Menghilangkan border */
            color: #dc3545 !important;
            /* Warna merah untuk 'Delete' */
        }

        .btn-delete:hover {
            color: #bd2130 !important;
            /* Warna merah gelap saat hover */
        }

        .table th,
        .table td {
            padding-top: 5px !important;
            /* Atur padding atas */
            padding-bottom: 5px !important;
            /* Atur padding bawah */
        }

        .table-rounded thead th:first-child {
            border-top-left-radius: 8px !important;
            /* Melengkungkan sudut kiri atas */
        }

        .table-rounded thead th:last-child {
            border-top-right-radius: 8px !important;
            /* Melengkungkan sudut kanan atas */
        }

        .table-rounded tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px !important;
            /* Melengkungkan sudut kiri bawah */
        }

        .table-rounded tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px !important;
            /* Melengkungkan sudut kanan bawah */
        }

        .tbl-container {
            margin-top: 10px;
        }

        .bg-green {
            background-color: green;
            color: white;
        }

        .bdr {
            border-radius: 6px;
            overflow: hidden;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px;
            /* Penambahan padding untuk memberi ruang */
        }

        .pagination-left,
        .pagination-center,
        .pagination-right {
            display: flex;
            align-items: center;
        }

        .pagination-center {
            justify-content: center;
            /* Menjaga dropdown di tengah */
        }

        .pagination-right {
            justify-content: flex-end;
            /* Pagination di kanan */
        }

        /* Mengatur lebar dropdown untuk menjadi lebih kecil */
        #per-page {
            width: 80px;
            /* Mengurangi lebar dropdown */
            padding: 0.375rem 0.75rem;
            /* Padding yang nyaman untuk dropdown */
            border-radius: 0.25rem;
            /* Radius yang serasi dengan Bootstrap */
            border: 1px solid #ced4da;
            /* Warna border seperti di Bootstrap */
        }
    </style>
@endpush

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="container">
                <div class="d-flex justify-content-between flex-wrap mb-2">
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createBagianModal">
                        Create Master Bagian
                    </button>
                </div>
                <div class="table-responsive tbl-container bdr">
                    <table class="table table-hover bg-white table-rounded" id="table_master_bagian">
                        <thead class="bg-green">
                            <tr>
                                <th scope="col">Nama bagian</th>
                                <th scope="col">Tanggal dibuat</th>
                                <th scope="col">Tanggal diupdate</th>
                                <th scope="col" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="pagination-container">
                    <div class="pagination-left">
                        <p class="results-info m-0">Showing <span id="result-start">1</span> to <span
                                id="result-end">10</span>
                            of <span id="total-results">36</span> results</p>
                    </div>
                    <div class="pagination-center">
                        <select id="per-page" class="form-control m-0">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                        </select>
                    </div>
                    <div class="pagination-right">
                        <nav aria-label="Page navigation">
                            <ul class="pagination m-0">
                                <!-- Pagination links will be appended here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Create Segment Modal --}}
    <div class="modal fade" id="createBagianModal" tabindex="-1" role="dialog" aria-labelledby="createBagianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBagianModalLabel">Create Master Bagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createBagianForm" method="POST">
                        @csrf
                        <input type="hidden" id="bagianId" name="id">
                        <div class="alert alert-danger d-none" id="error-message"></div>
                        <div class="form-group">
                            <label for="bagian">Nama Bagian : </label>
                            <div class="d-flex">
                                <select class="form-control" name="bagian" id="bagian" required>
                                    <option value="Regional">Regional</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Direktorat">Direktorat</option>
                                </select>
                                <input type="text" class="form-control ml-2" id="nama" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="outputBagian">Output Nama Bagian : </label>
                            <input type="text" class="form-control" id="outputBagian" name="outputBagian" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Segment Modal --}}
    <div class="modal fade" id="updateBagianModal" tabindex="-1" role="dialog" aria-labelledby="updateBagianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBagianModalLabel">Update Master Bagian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateBagianForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="bagianId" name="id"> <!-- Menyimpan ID bagian -->
                        <div class="alert alert-danger d-none" id="error-message"></div>
                        <div class="form-group">
                            <label for="bagianEdit">Nama Bagian : </label>
                            <div class="d-flex">
                                <select class="form-control" name="bagianEdit" id="bagianEdit" required>
                                    <option value="Regional">Regional</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Direktorat">Direktorat</option>
                                </select>
                                <input type="text" class="form-control ml-2" id="namaEdit" name="namaEdit" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="outputBagianEdit">Output Nama Bagian : </label>
                            <input type="text" class="form-control" id="outputBagianEdit" name="outputBagianEdit"
                                readonly>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateBagianBtn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    Apakah anda yakin ingin menghapus data Master Bagian ini?
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
            let currentPage = 1;
            let perPage = 10;

            loadData(1);

            $('#per-page').change(function() {
                perPage = $(this).val();
                loadData(currentPage, perPage);
            });

            function loadData(page) {
                $.ajax({
                    url: "{{ route('master-bagian.data') }}",
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: perPage
                    },
                    success: function(data) {
                        $('#table_master_bagian tbody').empty();
                        $('#result-start').text((page - 1) * perPage + 1);
                        $('#result-end').text(Math.min(page * perPage, data.pagination.total));
                        $('#total-results').text(data.pagination.total);

                        $.each(data.data, function(index, bagian) {
                            var urlShow = "{{ route('master-bagian.show', ':Id') }}".replace(
                                ':Id', bagian
                                .kpi_master_bagian_id);
                            var urlEdit = "{{ route('master-bagian.edit', ':Id') }}".replace(
                                ':Id', bagian
                                .kpi_master_bagian_id);
                            var row = `
                                <tr id="bagian-${bagian.kpi_master_bagian_id}">
                                    <td scope="row">${bagian.kpi_master_bagian_nama}</td>
                                    <td scope="row">${bagian.kpi_master_bagian_insert_at}</td>
                                    <td scope="row">${bagian.kpi_master_bagian_update_at}</td>
                                    <td scope="row">
                                        <button class="btn btn-sm btn-edit" data-toggle="modal" data-target="#updateBagianModal" data-id="${bagian.kpi_master_bagian_id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-delete deleteButton" type="button" data-toggle="modal" data-id="${bagian.kpi_master_bagian_id}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#table_master_bagian tbody').append(row);
                        });

                        let paginationLinks = '';
                        for (let i = 1; i <= data.pagination.last_page; i++) {
                            paginationLinks += `<li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
                        }

                        $('.pagination').html(paginationLinks);

                        $('.page-link').click(function(e) {
                            e.preventDefault();
                            currentPage = $(this).data('page');
                            loadData(currentPage, perPage);
                        });
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Failed to load data.');
                    }
                })
            }

            $('#bagian, #nama').on('change input', function() {
                $('#outputBagian').val($('#bagian').val() + ' ' + $('#nama').val());
            });

            $(document).on('submit', '#createBagianForm', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master-bagian.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createBagianModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Master bagian created successfully.');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#error-message').text(xhr.responseJSON.message).removeClass(
                                'd-none');
                        } else {
                            toastr.error('Failed to create master bagian.');
                        }
                    }
                });
            });

            // Update Master Bagian
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-bagian.get-data-by-id', ':Id') }}".replace(':Id', id),
                    method: 'GET',
                    success: function(response) {
                        if (response.data) {
                            let fullname = response.data.kpi_master_bagian_nama.split(' ');
                            $('#updateBagianModal #bagianId').val(id);
                            $('#updateBagianModal #bagianEdit').val(fullname[0]);
                            $('#updateBagianModal #namaEdit').val(fullname.slice(1).join(' '));
                            $('#updateBagianModal #outputBagianEdit').val(response.data
                                .kpi_master_bagian_nama);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        toastr.error('Failed to load data.');
                    }
                });
            });

            $('#bagianEdit, #namaEdit').on('change input', function() {
                $('#outputBagianEdit').val($('#bagianEdit').val() + ' ' + $('#namaEdit').val());
            });

            $(document).on('submit', '#updateBagianForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize(); // Mengumpulkan data form

                $.ajax({
                    url: "{{ route('master-bagian.update') }}", // Update dengan route yang sesuai
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#updateBagianModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Master bagian updated successfully.');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#updateBagianModal #error-message').text(xhr.responseJSON
                                .message).removeClass('d-none');
                        } else {
                            toastr.error('Failed to update master bagian.');
                        }
                    }
                });
            });

            var deleteUrl = '';
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                deleteUrl = `{{ route('master-bagian.destroy', ['id' => ':Id']) }}`.replace(':Id', id);
                console.log(deleteUrl);
                $('#deleteModal').modal('show');
            });

            $(document).on('click', '#confirmDelete', function() {
                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Master bagian deleted successfully.');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            console.log(xhr.responseJSON.message);
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                })
            });
        });
    </script>
@endpush
