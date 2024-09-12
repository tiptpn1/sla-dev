@extends('master/master')

@section('title', 'Data Master Username')

@section('master-username', 'active')

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
                        Create Master Username
                    </button>
                </div>
                <div class="table-responsive tbl-container bdr">
                    <table class="table table-hover bg-white table-rounded" id="table_master_bagian">
                        <thead class="bg-green">
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Divisi</th>
                                <th scope="col">Role</th>
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
                    <h5 class="modal-title" id="createBagianModalLabel">Create Master Username</h5>
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
                            <label for="username">Username : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="nama" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">Password : </label>
                            <div class="d-flex">
                                <input type="password" class="form-control ml-2" id="pass" name="pass" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi : </label>
                            <div class="d-flex">
                                <select class="form-control" name="divisi">
                                    <option selected>Pilih Divisi</option>
                                    @foreach ($all_divisi as $ad)
                                        <option value="{{ $ad->master_bagian_id }}">{{ $ad->master_bagian_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role : </label>
                                <div class="d-flex">
                                    <select class="form-control" name="role">
                                        <option selected>Pilih Role</option>
                                        @foreach ($hak_akses as $ha)
                                            <option value="{{ $ha->hak_akses_id }}">{{ $ha->hak_akses_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Segment Modal --}}
    <div class="modal fade" id="updateMasterUsername" tabindex="-1" role="dialog" aria-labelledby="updateBagianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBagianModalLabel">Update Master Username</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateUsernameForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="ubahUsernameId" name="id"> <!-- Menyimpan ID bagian -->
                        <div class="form-group">
                            <label for="username">Username : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="ubahUsername" name="nama"
                                    required>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="username">Password : </label>
                            <div class="d-flex">
                                <input type="password" class="form-control ml-2" id="ubahUserPass" name="pass">
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="divisi">Divisi : </label>
                            <div class="d-flex">
                                <select class="form-control" id="ubahUserDivisi" name="divisi">
                                    @foreach ($all_divisi as $ad)
                                        <option value="{{ $ad->master_bagian_id }}">{{ $ad->master_bagian_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role : </label>
                                <div class="d-flex">
                                    <select class="form-control" id="ubahUserRole" name="role">
                                        @foreach ($hak_akses as $ha)
                                            <option value="{{ $ha->hak_akses_id }}">{{ $ha->hak_akses_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                    Apakah anda yakin ingin menghapus data Master Username ini?
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
                    url: "{{ route('master-username.data') }}",
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

                        $.each(data.data, function(index, username) {
                            // var urlShow = "{{ route('master-username.show', ':Id') }}".replace(
                            //   ':Id', username
                            // .master_user_id);
                            //var urlEdit = "{{ route('master-username.edit', ':Id') }}".replace(
                            //  ':Id', username
                            //.master_user_id);
                            var row = `
                                <tr id="bagian-${username.master_user_id}">
                                    <td scope="row">${username.master_user_nama}</td>
                                    <td scope="row">${username.master_bagian_nama}</td>
                                    <td scope="row">${username.hak_akses_nama}</td>
                                    <td scope="row">
                                        <button class="btn btn-sm btn-edit" data-toggle="modal" onclick="ubahUserData(this)" data-id="${username.master_user_id}" data-username="${username.master_user_nama}" data-bagian="${username.master_nama_bagian_id}" data-hak="${username.master_hak_akses_id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-delete deleteButton" type="button" data-toggle="modal" data-id="${username.master_user_id}">
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
                    url: "{{ route('master-username.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createBagianModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Master username created successfully.');
                    },
                    error: function(xhr, status, error) {
                        console.log(data);
                        console.error(xhr.responseText);
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#error-message').text(xhr.responseJSON.message).removeClass(
                                'd-none');
                        } else {
                            toastr.error('Failed to create master username.');
                        }
                    }
                });
            });

            // Update Master Username
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-username.get-data-by-id', ':Id') }}".replace(':Id', id),
                    method: 'GET',
                    success: function(response) {
                        if (response.data) {
                            let fullname = response.data.master_user_nama;
                            $('#updateBagianModal #bagianId').val(id);
                            //$('#updateBagianModal #bagianEdit').val(fullname[0]);
                            $('#updateBagianModal #editnama').val(fullname);
                            //$('#updateBagianModal #outputBagianEdit').val(response.data
                            //  .kpi_master_bagian_nama);
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

            $(document).on('submit', '#updateUsernameForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize(); // Mengumpulkan data form

                $.ajax({
                    url: "{{ route('master-username.update') }}", // Update dengan route yang sesuai
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#updateMasterUsername').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Master username updated successfully.');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#updateBagianModal #error-message').text(xhr.responseJSON
                                .message).removeClass('d-none');
                        } else {
                            toastr.error('Failed to update master username.');
                        }
                    }
                });
            });

            var deleteUrl = '';
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                deleteUrl = `{{ route('master-username.destroy', ['id' => ':Id']) }}`.replace(':Id', id);
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
                        toastr.success('Master username deleted successfully.');
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

    <script>
        function ubahUserData(button) {
            id = $(button).data('id');
            username = $(button).data('username');
            bagian = $(button).data('bagian');
            hak = $(button).data('hak');

            $('#ubahUsernameId').val(id);
            $('#ubahUsername').val(username);
            $('#ubahUserDivisi').val(bagian);
            $('#ubahUserRole').val(hak);

            $('#updateMasterUsername').modal('show');
        }
    </script>
@endpush
