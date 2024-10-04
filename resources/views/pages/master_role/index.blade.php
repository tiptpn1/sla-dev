@extends('master/master')

@section('title', 'Data Master Hak Akses')

@section('master-role', 'active')

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
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createRoleModal">
                        Create Master Hak Akses
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="masterHakAksesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hak Akses</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data akan diisi oleh DataTables  --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Segment Modal --}}
    <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Create Master Hak Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createRoleForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Hak Akses : </label>
                            <input type="text" class="form-control ml-2" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Segment Modal --}}
    <div class="modal fade" id="updateRoleModal" tabindex="-1" role="dialog" aria-labelledby="updateRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateRoleModalLabel">Update Master Hak Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateRoleForm">
                    <div class="modal-body">
                        <input type="hidden" id="roleId" name="id"> <!-- Menyimpan ID bagian -->
                        <div class="form-group">
                            <label for="editName">Nama Hak Akses : </label>
                            <input type="text" class="form-control ml-2" id="editName" name="editName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                    Apakah anda yakin ingin menghapus data Master Hak Akses ini?
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function fetchRoleData() {
                $.ajax({
                    url: "{{ route('master-role.data') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var table = $('#masterHakAksesTable').DataTable();
                        table.clear();
                        $.each(data, function(index, item) {
                            table.row.add([
                                index + 1,
                                item.hak_akses_nama,
                                '<button class="btn btn-warning btn-sm edit-btn" data-id="' +
                                item.hak_akses_id + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-id="' +
                                item.hak_akses_id + '">Hapus</button> '
                            ]).draw();
                        });
                    }
                })
            }

            fetchRoleData();

            // Create Role
            $('#createRoleForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master-role.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#createRoleForm')[0].reset();
                            $('#createRoleModal').modal('hide');
                            fetchRoleData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errors
                        });
                    }
                })
            });

            // Edit User
            $('#masterHakAksesTable').on('click', '.edit-btn', function(e) {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-role.get-data-by-id', ':id') }}".replace(':id', id),
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#updateRoleModal').modal('show');
                        $('#roleId').val(response.hak_akses_id);
                        $('#editName').val(response.hak_akses_nama);
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errors
                        });
                    }
                })
            })

            $('#updateRoleForm').on('submit', function(e) {
                e.preventDefault();

                var id = $('#roleId').val();
                var name = $('#editName').val();
                $.ajax({
                    url: "{{ route('master-role.update') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        name: name,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#updateRoleModal').modal('hide');
                            fetchRoleData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Hak Akses berhasil diperbarui',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errors
                        });
                    }
                });
            });

            // Delete User
            $('#masterHakAksesTable').on('click', '.delete-btn', function(e) {
                var id = $(this).data('id');
                $('#confirmDelete').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-role.destroy', ':id') }}".replace(':id', id),
                    method: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#deleteModal').modal('hide');
                            fetchRoleData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Role berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errors
                        });
                    }
                })
            });
        });
    </script>
@endpush
