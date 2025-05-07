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
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Create Master
                        Username</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="masterUserTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Nama Bagian</th>
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
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create Master Username</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createUserForm">
                    <div class="modal-body">
                        @csrf
                        {{-- <div class="alert alert-danger d-none" id="error-message"></div> --}}
                        <div class="form-group">
                            <label for="username">Username : </label>
                            <input type="text" class="form-control ml-2" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password : </label>
                            <input type="password" class="form-control ml-2" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role : </label>
                            <select class="form-control" id="role" name="role">
                                <option selected>Pilih Role</option>
                                @foreach ($hak_akses as $ha)
                                    <option value="{{ $ha->hak_akses_id }}">{{ $ha->hak_akses_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Nama Bagian : </label>
                            <select class="form-control" id="divisi" name="divisi">
                                <option selected>Pilih Bagian</option>
                                @foreach ($all_divisi as $divisi)
                                    <option value="{{ $divisi->master_bagian_id }}" data-posisi="{{ $divisi->master_bagian_posisi }}">
                                        {{ $divisi->master_bagian_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Segment Modal --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Master User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id"> <!-- Menyimpan ID bagian -->
                        <div class="form-group">
                            <label for="editUsername">Username : </label>
                            <input type="text" class="form-control ml-2" id="editUsername" name="editUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role : </label>
                            <select class="form-control" id="editRole" name="editRole">
                                @foreach ($hak_akses as $ha)
                                    <option value="{{ $ha->hak_akses_id }}">{{ $ha->hak_akses_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editUserDivisi">Nama Bagian : </label>
                            <select class="form-control" id="editUserDivisi" name="editUserDivisi">
                                @foreach ($all_divisi as $divisi)
                                    <option value="{{ $divisi->master_bagian_id }}" data-posisi="{{ $divisi->master_bagian_posisi }}">
                                        {{ $divisi->master_bagian_nama }}
                                    </option>
                                @endforeach
                            </select>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let originalDivisiOptions = $('#divisi').html(); // untuk create
            let originalEditDivisiOptions = $('#editUserDivisi').html(); // untuk edit

            // Role-Bagian filtering
            $('#role').on('change', function() {
                let selectedRoleText = $('#role option:selected').text().toLowerCase();
                let roleKeyword = '';

                // Reset ke semua option awal
                $('#divisi').html(originalDivisiOptions);

                if (selectedRoleText.includes('direktorat')) {
                    $.ajax({
                        url: "{{ route('master-direktorat.get-data') }}",
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">-- Pilih Direktorat --</option>';
                            response.forEach(function(item) {
                                options += `<option value="${item.direktorat_id}">${item.nama}</option>`;
                            });
                            $('#divisi').html(options); 
                        }
                    });
                    return; 
                } 

                if (selectedRoleText.includes('subdivisi') || selectedRoleText.includes('koordinator sub divisi'))  {
                    $.ajax({
                        url: "{{ route('master-sub-divisi.data') }}",
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">-- Pilih Sub Divisi --</option>';
                            response.forEach(function(item) {
                                options += `<option value="${item.id}">${item.sub_bagian_nama}</option>`;
                            });
                            $('#divisi').html(options); 
                        }
                    });
                    return;
                }

                // Untuk role lainnya, filter berdasarkan keyword
                if (selectedRoleText.includes('divisi') || selectedRoleText.includes('koordinator divisi')) {
                    roleKeyword = 'Div';
                } else if (selectedRoleText.includes('direksi')) {
                    roleKeyword = 'Reg';
                } else if (selectedRoleText.includes('admin')) {
                    roleKeyword = 'Admin';
                } else if (selectedRoleText.includes('kordinator')) {
                    roleKeyword = 'Koor';
                } 

                // Filter berdasarkan posisi dari data-posisi
                $('#divisi option').each(function () {
                    let posisi = $(this).data('posisi');
                    if (posisi !== roleKeyword && posisi !== undefined) {
                        $(this).remove(); // Hapus option yang tidak sesuai
                    }
                });
            });

            function fetchUserData() {
                $.ajax({
                    url: "{{ route('master-username.data') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var table = $('#masterUserTable').DataTable();
                        table.clear();

                        $.each(data, function(index, item) {
                            let bagianNama = '—';

                            if (item.sub_bagian && item.sub_bagian.sub_bagian_nama) {
                                bagianNama = item.sub_bagian.sub_bagian_nama;
                            } else if (item.bagian && item.bagian.master_bagian_nama) {
                                bagianNama = item.bagian.master_bagian_nama;
                            } else if (item.direktorat && item.direktorat.nama) {
                                bagianNama = item.direktorat.nama;
                            }

                            table.row.add([
                                index + 1,
                                item.master_user_nama ?? '—',
                                item.hak_akses?.hak_akses_nama ?? '—',
                                bagianNama,
                                '<button class="btn btn-warning btn-sm edit-btn" data-id="' + item.master_user_id + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-id="' + item.master_user_id + '">Hapus</button>'
                            ]).draw();
                        });
                    }
                })
            }

            fetchUserData();

            // Create User
            $('#createUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master-username.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#createUserModal').modal('hide');
                            fetchUserData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                })
            });

            // Edit User
            $('#masterUserTable').on('click', '.edit-btn', function () {
                const id = $(this).data('id');
                $.get("{{ route('master-username.get-data-by-id', ':id') }}".replace(':id', id), function (response) {
                    $('#editUserModal').modal('show');
                    $('#editId').val(response.master_user_id);
                    $('#editUsername').val(response.master_user_nama);
                    $('#editRole').val(response.master_hak_akses_id);

                    loadDivisiOptions(response.master_hak_akses_id, response);
                });
            });

            // Load divisi berdasarkan role
            function loadDivisiOptions(roleId, userData = {}) {
                const roleText = $('#editRole option[value="' + roleId + '"]').text().toLowerCase();
                let url = '';
                let label = '-- Pilih Divisi --';
                let idKey = '';
                let nameKey = '';
                let selectedValue = '';

                if (roleText.includes('direktorat')) {
                    url = "{{ route('master-direktorat.get-data') }}";
                    label = '-- Pilih Direktorat --';
                    idKey = 'direktorat_id';
                    nameKey = 'nama';
                    selectedValue = userData?.direktorat_id;
                } else if (roleText.includes('subdivisi') || roleText.includes('koordinator sub divisi')) {
                    url = "{{ route('master-sub-divisi.data') }}";
                    label = '-- Pilih Sub Divisi --';
                    idKey = 'id';
                    nameKey = 'sub_bagian_nama';
                    selectedValue = userData?.id_sub_divisi;
                } else {
                    url = "{{ route('master-bagian.get-data') }}";
                    label = '-- Pilih Bagian --';
                    idKey = 'master_bagian_id';
                    nameKey = 'master_bagian_nama';
                    selectedValue = userData?.master_nama_bagian_id;
                }

                $.get(url, function (data) {
                    let options = `<option value="">${label}</option>`;
                    data.forEach(item => {
                        options += `<option value="${item[idKey]}">${item[nameKey]}</option>`;
                    });
                    $('#editUserDivisi').html(options).val(selectedValue || '');
                });
            }

            // Saat Role diubah manual oleh user
            $('#editRole').on('change', function () {
                loadDivisiOptions($(this).val());
            });

            // Submit form
            $('#editUserForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master-username.update') }}",
                    method: 'PUT',
                    data: {
                        id: $('#editId').val(),
                        username: $('#editUsername').val(),
                        divisi: $('#editUserDivisi').val(),
                        role: $('#editRole').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            $('#editUserModal').modal('hide');
                            fetchUserData(); // Refresh data
                            Swal.fire({ icon: 'success', title: 'Data berhasil diperbarui', showConfirmButton: false, timer: 1500 });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON.message });
                    }
                });
            });

            // Delete User
            $('#masterUserTable').on('click', '.delete-btn', function(e) {
                var id = $(this).data('id');
                $('#confirmDelete').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-username.destroy', ':id') }}".replace(':id', id),
                    method: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#deleteModal').modal('hide');
                            fetchUserData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data User berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                })
            });
        });
    </script>
@endpush

