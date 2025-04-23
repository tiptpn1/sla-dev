@extends('master/master')

@section('title', 'Data Master Sub Divisi')

@section('master-sub-divisi', 'active')

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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createSubDivisiModal">Create Master
                        Sub Divisi</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="masterSubDivisiTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sub Divisi</th>
                                    <th>Kode</th>
                                    <th>Divisi</th>
                                    <th>Direktorat</th>
                                    <th>Status</th>
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
    <div class="modal fade" id="createSubDivisiModal" tabindex="-1" role="dialog" aria-labelledby="createSubDivisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubDivisiModalLabel">Create Master Sub Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createSubDivisiForm">
                    <div class="modal-body">
                        @csrf
                        {{-- <div class="alert alert-danger d-none" id="error-message"></div> --}}
                        <div class="form-group">
                            <label for="nama">Sub Divisi : </label>
                            <input type="text" class="form-control ml-2" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode : </label>
                            <input type="text" class="form-control ml-2" id="kode" name="kode" required>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi : </label>
                            <select class="form-control" id="divisi" name="divisi">
                                <option selected>Pilih Divisi</option>
                                @foreach ($all_divisi as $divisi)
                                    <option value="{{ $divisi->master_bagian_id }}">{{ $divisi->master_bagian_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <label for="direktorat">Direktorat : </label>
                                <input type="hidden" id="direktorat" name="direktorat">
                                <select class="form-control" id="direktorat" name="direktorat">
                                    <option selected>Pilih Direktorat</option>
                                    @foreach ($direktorat as $dir)
                                        <option value="{{ $dir->direktorat_id }}">{{ $dir->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status Aktif</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
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
    <div class="modal fade" id="editSubDivisiModal" tabindex="-1" role="dialog" aria-labelledby="editSubDivisiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubDivisiModalLabel">Edit Master Sub Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSubDivisiForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id"> <!-- Menyimpan ID bagian -->
                        <div class="form-group">
                            <label for="editSubDivisi">Sub Divisi : </label>
                            <input type="text" class="form-control ml-2" id="editSubDivisi" name="editSubDivisi" required>
                        </div>
                        <div class="form-group">
                            <label for="editKode">Kode : </label>
                            <input type="text" class="form-control ml-2" id="editKode" name="editKode" required>
                        </div>
                        <div class="form-group">
                            <label for="editDivisi">Divisi : </label>
                            <select class="form-control" id="editDivisi" name="editDivisi">
                                @foreach ($all_divisi as $divisi)
                                    <option value="{{ $divisi->master_bagian_id }}">{{ $divisi->master_bagian_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editDirektorat">Direktorat : </label>
                            <select class="form-control" id="editDirektorat" name="editDirektorat">
                                @foreach ($direktorat as $dir)
                                    <option value="{{ $dir->direktorat_id }}">{{ $dir->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status Aktif</label>
                            <select class="form-control" id="editStatus" name="editStatus" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
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
 
            function fetchUserData() {
                $.ajax({
                    url: "{{ route('master-sub-divisi.data') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var table = $('#masterSubDivisiTable').DataTable();
                        table.clear();
                        $.each(data, function(index, item) {
                            table.row.add([
                                index + 1,
                                item.sub_bagian_nama,
                                item.sub_bagian_kode,
                                item.bagian.master_bagian_nama,
                                item.direktorat.nama,
                                '<span class="badge ' + (item.status ? 'badge-success' : 'badge-danger') + '">' + (item.status ? 'Aktif' : 'Nonaktif') + '</span>',
                                '<button class="btn btn-warning btn-sm edit-btn" data-id="' + item.id + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-id="' + item.id + '">Hapus</button> ' +
                                '<button class="btn btn-info btn-sm status-btn" data-id="'+ item.id +'" data-status="'+ (item.status ? 0 : 1) +'">' + (item.status ? 'Nonaktifkan' : 'Aktifkan') + '</button>'
                            ]).draw();
                        });
                    }
                })
            }

            fetchUserData();

            // Create User
            $('#createSubDivisiForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master-sub-divisi.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#createSubDivisiModal').modal('hide');
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

            // Edit Sub Divisi
            $('#masterSubDivisiTable').on('click', '.edit-btn', function(e) {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-sub-divisi.get-data-by-id', ':id') }}".replace(':id', id),
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#editSubDivisiModal').modal('show');
                        $('#editId').val(response.id);
                        $('#editSubDivisi').val(response.sub_bagian_nama);
                        $('#editKode').val(response.sub_bagian_kode);
                        $('#editDivisi').val(response.master_bagian_id);
                        $('#editDirektorat').val(response.direktorat_id);
                        $('#editStatus').val(response.status ? 1 : 0);
                    }
                })
            })

            $('#editSubDivisiForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#editId').val();
                var nama = $('#editSubDivisi').val();
                var kode = $('#editKode').val();
                var divisi = $('#editDivisi').val();
                var direktorat = $('#editDirektorat').val();
                var status = $('#editStatus').val()
                $.ajax({
                    url: "{{ route('master-sub-divisi.update', ':id') }}".replace(':id', id),
                    method: 'PUT',
                    data: {
                        id: id,
                        nama: nama,
                        kode: kode,
                        divisi: divisi,
                        direktorat: direktorat,
                        status: status,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editSubDivisiModal').modal('hide');
                            fetchUserData();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data User berhasil diperbarui',
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
            })

            // Delete User
            $('#masterSubDivisiTable').on('click', '.delete-btn', function(e) {
                var id = $(this).data('id');
                $('#confirmDelete').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('master-sub-divisi.destroy', ':id') }}".replace(':id', id),
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
            })

            // Update status aktif/nonaktif
            $('#masterSubDivisiTable').on('click', '.status-btn', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    url: '{{ route("master-sub-divisi.update-status", ":id") }}'.replace(':id', id),
                    method: 'POST',
                    data: { status: status },
                    success: function(response) {
                        if (response.status === 'success') {
                            fetchUserData();
                            Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        }
                    }
                });
            });
        });
    </script>
@endpush
