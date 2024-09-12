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
<div class="content">
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
       

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Master Bagian</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="masterBagianTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Bagian</th>
                                <th>Status Aktif</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Master Bagian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaBagian">Nama Bagian</label>
                        <input type="text" class="form-control" id="namaBagian" name="namaBagian" required>
                    </div>
                    <div class="form-group">
                        <label for="isActive">Status Aktif</label>
                        <select class="form-control" id="isActive" name="isActive" required>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Master Bagian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="editNamaBagian">Nama Bagian</label>
                        <input type="text" class="form-control" id="editNamaBagian" name="editNamaBagian" required>
                    </div>
                    <div class="form-group">
                        <label for="editIsActive">Status Aktif</label>
                        <select class="form-control" id="editIsActive" name="editIsActive" required>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Set CSRF token in AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Ambil data dan isi tabel
    function fetchData() {
        $.ajax({
            url: '{{ route("master-bagian.get-data") }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#masterBagianTable').DataTable();
                table.clear();
                $.each(data, function(index, item) {
                    table.row.add([
                        index + 1,
                        item.master_bagian_nama,
                        '<span class="badge ' + (item.is_active ? 'badge-success' : 'badge-danger') + '">' + (item.is_active ? 'Aktif' : 'Nonaktif') + '</span>',
                        '<button class="btn btn-warning btn-sm edit-btn" data-id="'+ item.master_bagian_id +'">Edit</button> ' +
                        '<button class="btn btn-danger btn-sm delete-btn" data-id="'+ item.master_bagian_id +'">Hapus</button> ' +
                        '<button class="btn btn-info btn-sm status-btn" data-id="'+ item.master_bagian_id +'" data-status="'+ (item.is_active ? 0 : 1) +'">' + (item.is_active ? 'Nonaktifkan' : 'Aktifkan') + '</button>'
                    ]).draw();
                });
            }
        });
    }

    fetchData();

    // Tambah data
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("master-bagian.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    $('#addModal').modal('hide');
                    fetchData();
                }
            }
        });
    });

    // Edit data
    $('#masterBagianTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("master-bagian.get-data-id", ":id") }}'.replace(':id', id),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#editId').val(data.master_bagian_id);
                $('#editNamaBagian').val(data.master_bagian_nama);
                $('#editIsActive').val(data.is_active ? 1 : 0);
                $('#editModal').modal('show');
            }
        });
    });

    $('#editForm').on('submit', function(e) {
    e.preventDefault();
    var id = $('#editId').val();
    
    $.ajax({
        url: '{{ route("master-bagian.update-form", ":id") }}'.replace(':id', id),
        method: 'POST',
        data: {
            namaBagian: $('#editNamaBagian').val(),
            status: $('#editIsActive').val()
        },
        
        success: function(response) {
            if (response.status === 'success') {
                $('#editModal').modal('hide');
                fetchData();
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


    // Hapus data
    $('#masterBagianTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $('#deleteModal').modal('show');
        $('#confirmDelete').data('id', id);
    });

    $('#confirmDelete').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route("master-bagian.delete", ":id") }}'.replace(':id', id),
            method: 'DELETE',
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    fetchData();
                    Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });
                }
            }
        });
    });

    // Update status aktif/nonaktif
    $('#masterBagianTable').on('click', '.status-btn', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: '{{ route("master-bagian.update-status", ":id") }}'.replace(':id', id),
            method: 'POST',
            data: { status: status },
            success: function(response) {
                if (response.status === 'success') {
                    fetchData();
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush



