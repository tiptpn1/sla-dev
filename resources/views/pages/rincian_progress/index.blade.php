@extends('master/master')

@section('title', 'Rincian Progress Dari Activity "' . $activity->nama_activity . '"')

@section('dashboard', 'active')

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

        .btn-evidence,.btn-download {
            background-color: transparent !important;
            /* Membuat latar belakang transparan */
            border: none !important;
            /* Menghilangkan border */
            color: #3475FFFF !important;
            /* Warna oranye untuk 'Edit' */
        }

        .btn-evidence:hover,.btn-download:hover {
            color: #00277CFF !important;
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
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" onclick="tambahRincianProgress()">
                        Tambah Rincian Progress
                    </button>
                </div>
                <div class="table-responsive tbl-container bdr">
                    <table class="table table-hover bg-white table-rounded" id="table_rincian_progress">
                        <thead class="bg-green">
                            <tr>
                                <th scope="col">Rincian Progress</th>
                                <th scope="col">Kendala</th>
                                <th scope="col">Tindak Lanjut</th>
                                {{-- <th scope="col">Evidence</th> --}}
                                <th scope="col" width="22%" style="text-align: center">Actions</th>
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
                            <ul class="pagination pagination-rincian m-0">
                                <!-- Pagination links will be appended here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Create Segment Modal --}}
    <div class="modal fade" id="createRincianProgressModal" tabindex="-1" role="dialog"
        aria-labelledby="createRincianProgressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRincianProgressModalLabel">Tambah Rincian Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRincianProgressForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="addActivityId" name="activity_id" value="{{ $activity->id_activity }}">
                        <div class="alert alert-danger d-none" id="error-message"></div>
                        <div class="form-group">
                            <label for="addRincianProgress">Rincian Progress : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="addRincianProgress"
                                    name="rincian_progress" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addKendala">Kendala : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="addKendala" name="kendala">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addTindakLanjut">Tindak Lanjut : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="addTindakLanjut" name="tindak_lanjut"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addEvidence">File Evidence : </label>
                            <div class="d-flex">
                                <input type="file" class="form-control ml-2" id="addEvidence" name="file_evidence">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Segment Modal --}}
    <div class="modal fade" id="updateRincianProgressModal" tabindex="-1" role="dialog"
        aria-labelledby="updateBagianModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBagianModalLabel">Update Rincian Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateRincianProgressForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="ubahRincianProgressId" name="id">
                        <!-- Menyimpan ID rincian progress -->
                        <div class="form-group">
                            <label for="rincianProgress">Rincian Progress : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="ubahRincianProgress"
                                    name="rincian_progress" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kendala">Kendala : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="ubahKendala" name="kendala">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tindakLanjut">Tindak Lanjut : </label>
                            <div class="d-flex">
                                <input type="text" class="form-control ml-2" id="ubahTindakLanjut"
                                    name="tindak_lanjut" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateBagianBtn">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Evidence --}}
    <div class="modal fade" id="crudEvidenceModal" tabindex="-1" role="dialog"
        aria-labelledby="crudEvidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crudEvidenceModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="d-flex justify-content-between flex-wrap mb-2">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="progress_id" id="rincianProgressIdForEvidence">
                                <input type="file" style="display: none;" name="file_evidence" onchange="addFileEvidence(this)" id="addFileEvidenceFromDetail">
                                <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                                    onclick="document.getElementById('addFileEvidenceFromDetail').click()">
                                    Tambah Evidence
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive tbl-container bdr">
                            <table class="table table-hover bg-white table-rounded" id="table_evidence">
                                <thead class="bg-green">
                                    <tr>
                                        <th scope="col">File</th>
                                        <th scope="col" width="35%" style="text-align: center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="pagination-container">
                            <div class="pagination-left">
                                <p class="results-info m-0">Showing <span id="result-start-evidence">1</span> to <span
                                        id="result-end-evidence">10</span>
                                    of <span id="total-results-evidence">36</span> results</p>
                            </div>
                            <div class="pagination-center">
                                <select id="per-page-evidence" class="form-control m-0">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                            </div>
                            <div class="pagination-right">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-evidence m-0">
                                        <!-- Pagination links will be appended here -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
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
                    Apakah anda yakin ingin menghapus data rincian progress ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEvidence" tabindex="-1" role="dialog" aria-labelledby="deleteEvidenceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEvidenceLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteFileEvidenceText"></div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" name="id_evidence" id="deleteFileEvidenceId">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDeleteFileEvidence()">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Update --}}
    <div class="modal fade" id="updateEvidenceModal" tabindex="-1" role="dialog" aria-labelledby="updateEvidenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEvidenceModalLabel">Confirm Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="updateEvidenceModalText"></div>
                <div class="modal-footer">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_evidence" id="updateFileEvidenceId">
                        <input type="file" style="display: none" name="file_evidence" id="updateFileEvidence" onchange="confirmUbahFileEvidence(this)">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('updateFileEvidence').click()">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPageEvidence = 1;
        let perPageEvidence = 5;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });

            let rincianProgressId = 0;

            let currentPage = 1;
            let perPage = 10;

            loadData(1);

            $('#per-page').change(function() {
                perPage = $(this).val();
                loadData(currentPage, perPage);
            });

            $('#per-page-evidence').change(function() {
                perPageEvidence = $(this).val();
                loadDataEvidence(currentPageEvidence, perPageEvidence);
            });

            function loadData(page) {
                $.ajax({
                    url: "{{ route('rincian.getData') }}",
                    method: 'POST',
                    data: {
                        page: page,
                        per_page: perPage,
                        activity_id: '{{ $id }}',
                    },
                    success: function(data) {
                        $('#table_rincian_progress tbody').empty();
                        $('#result-start').text((page - 1) * perPage + 1);
                        $('#result-end').text(Math.min(page * perPage, data.pagination.total));
                        $('#total-results').text(data.pagination.total);

                        $.each(data.data, function(index, rincian) {
                            var row = `
                                <tr id="bagian-${rincian.id}">
                                    <td scope="row">${rincian.rincian_progress ?? '-'}</td>
                                    <td scope="row">${rincian.kendala ?? '-'}</td>
                                    <td scope="row">${rincian.tindak_lanjut ?? '-'}</td>
                                    <td scope="row" width="22%">
                                        <button class="btn btn-sm btn-evidence" data-toggle="modal" onclick=showEvidence(this) data-id="${rincian.id}" data-rincian_progress="${rincian.rincian_progress}">
                                            <i class="fas fa-file"></i> Evidence
                                        </button>
                                        <button class="btn btn-sm btn-edit" data-toggle="modal" onclick="ubahRincianProgress(this)" data-id="${rincian.id}" data-rincian_progress="${rincian.rincian_progress}" data-kendala="${rincian.kendala}" data-tindak_lanjut="${rincian.tindak_lanjut}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-delete deleteButton" type="button" data-toggle="modal" data-id="${rincian.id}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                            $('#table_rincian_progress tbody').append(row);
                        });

                        let paginationLinks = '';
                        for (let i = 1; i <= data.pagination.last_page; i++) {
                            paginationLinks += `<li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link page-link-rincian" href="#" data-page="${i}">${i}</a>
                            </li>`;
                        }

                        $('.pagination-rincian').html(paginationLinks);

                        $('.page-link-rincian').click(function(e) {
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

            $(document).on('submit', '#createRincianProgressForm', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('rincian.store') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: new FormData(this),
                    success: function(response) {
                        $('#createRincianProgressModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Rincian progress created successfully.');
                    },
                    error: function(xhr, status, error) {
                        // console.log(data);
                        // console.error(xhr.responseText);
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#error-message').text(xhr.responseJSON.message).removeClass(
                                'd-none');
                        } else {
                            toastr.error('Failed to create rincian progress.');
                        }
                    }
                });
            });

            $('#bagianEdit, #namaEdit').on('change input', function() {
                $('#outputBagianEdit').val($('#bagianEdit').val() + ' ' + $('#namaEdit').val());
            });

            $(document).on('submit', '#updateRincianProgressForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize(); // Mengumpulkan data form

                $.ajax({
                    url: "{{ route('rincian.update') }}", // Update dengan route yang sesuai
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#updateRincianProgressModal').modal('hide');
                        loadData(currentPage, perPage);
                        toastr.success('Rincian progress updated successfully.');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 400) { // Jika ada kesalahan validasi
                            $('#updateBagianModal #error-message').text(xhr.responseJSON
                                .message).removeClass('d-none');
                        } else {
                            toastr.error('Failed to update rincian progress.');
                        }
                    }
                });
            });

            var deleteUrl = '';
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                deleteUrl = `{{ route('rincian.delete', ['id' => ':Id']) }}`.replace(':Id', id);
                // console.log(deleteUrl);
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
                        toastr.success('Rincian progress deleted successfully.');
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
        function tambahRincianProgress() {
            $('#error-message').text('').addClass('d-none');
            $('#addRincianProgress').val('');
            $('#addKendala').val('');
            $('#addTindakLanjut').val('');
            $('#addEvidence').val('');

            $('#createRincianProgressModal').modal('show');
        }

        function ubahRincianProgress(button) {
            id = $(button).data('id');
            rincian_progress = $(button).data('rincian_progress');
            kendala = $(button).data('kendala');
            tindak_lanjut = $(button).data('tindak_lanjut');

            $('#ubahRincianProgressId').val(id);
            $('#ubahRincianProgress').val(rincian_progress);
            $('#ubahKendala').val(kendala);
            $('#ubahTindakLanjut').val(tindak_lanjut);

            $('#updateRincianProgressModal').modal('show');
        }

        function loadDataEvidence() {
            $('#table_evidence tbody').empty();

            $.ajax({
                url: "{{ route('evidence.show') }}",
                method: 'POST',
                data: {
                    page: currentPageEvidence,
                    per_page: perPageEvidence,
                    rincian_progress_id: rincianProgressId,
                },
                success: function(data) {
                    $('#result-start-evidence').text((currentPageEvidence - 1) * perPageEvidence + 1);
                    $('#result-end-evidence').text(Math.min(currentPageEvidence * perPageEvidence, data.pagination.total));
                    $('#total-results-evidence').text(data.pagination.total);

                    $.each(data.data, function(index, evidence) {
                        var row = `
                            <tr id="bagian-${evidence.id_evidence}">
                                <td scope="row">${evidence.filename}</td>
                                <td scope="row" width="35%">
                                    <button class="btn btn-sm btn-download" data-toggle="modal" onclick=downloadEvidence(this) data-id="${evidence.id_evidence}" data-filename=${evidence.filename}>
                                        <i class="fas fa-download"></i> Unduh
                                    </button>
                                    <button class="btn btn-sm btn-edit" data-toggle="modal" onclick="ubahFileEvidence(this)" data-id="${evidence.id_evidence}" data-filename="${evidence.filename}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-delete" type="button" data-toggle="modal" onclick="deleteFileEvidence(this)" data-id="${evidence.id_evidence}" data-filename=${evidence.filename}>
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('#table_evidence tbody').append(row);
                    });

                    let paginationLinksEvidence = '';
                    for (let i = 1; i <= data.pagination.last_page; i++) {
                        paginationLinksEvidence += `<li class="page-item ${i === currentPageEvidence ? 'active' : ''}">
                            <a class="page-link page-link-evidence" href="#" data-page="${i}">${i}</a>
                        </li>`;
                    }

                    $('.pagination-evidence').html(paginationLinksEvidence);

                    $('.page-link-evidence').click(function(e) {
                        e.preventDefault();
                        currentPageEvidence = $(this).data('page');
                        loadDataEvidence()
                    });
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to load data.');
                }
            });
        }

        function showEvidence(button) {
            currentPageEvidence = 1;
            perPageEvidence = 5;

            $('#per-page-evidence').val('5');

            rincian_progress = $(button).data('rincian_progress');
            rincianProgressId = $(button).data('id');

            $('#rincianProgressIdForEvidence').val(rincianProgressId);

            $('#crudEvidenceModalLabel').text(`Evidence dari rincian progress "${rincian_progress}"`);

            loadDataEvidence();

            $('#crudEvidenceModal').modal('show');
        }

        function addFileEvidence(input) {
            if ($(input).val() != undefined && $(input).val() != null) {
                form = $(input).closest('form');

                $.ajax({
                    url: "{{ route('evidence.upload') }}", // Update dengan route yang sesuai
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: new FormData(form[0]),
                    success: function(response) {
                        $(input).val('');
                        loadDataEvidence(currentPageEvidence, perPageEvidence);
                        toastr.success('Evidence upload successfully.');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Failed to upload evidence.');
                    }
                });
            }
        }

        function confirmUbahFileEvidence(input) {
            if ($(input).val() != undefined && $(input).val() != null) {
                form = $(input).closest('form');

                $.ajax({
                    url: "{{ route('evidence.update') }}", // Update dengan route yang sesuai
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: new FormData(form[0]),
                    success: function(response) {
                        $(input).val('');
                        $('#updateEvidenceModal').modal('hide');
                        loadDataEvidence(currentPageEvidence, perPageEvidence);
                        toastr.success('Evidence updated successfully.');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Failed to updated evidence.');
                    }
                });
            }
        }

        function ubahFileEvidence(button) {
            id_evidence = $(button).data('id');
            filename = $(button).data('filename');

            $('#updateEvidenceModalText').text(`Apakah anda yakin ingin mengubah file evidence ${filename}?`);
            $('#updateFileEvidenceId').val(id_evidence);

            $('#updateEvidenceModal').modal('show');
        }

        function confirmDeleteFileEvidence() {
            id_evidence = $('#deleteFileEvidenceId').val();

            $.ajax({
                url: "{{ route('evidence.delete') }}",
                method: 'DELETE',
                data: {
                    id_evidence: id_evidence,
                },
                success: function(response) {
                    $('#deleteEvidence').modal('hide');
                    loadDataEvidence(currentPageEvidence, perPageEvidence);
                    toastr.success('Evidence updated successfully.');
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to upload evidence.');
                }
            });
        }

        function deleteFileEvidence(button) {
            id_evidence = $(button).data('id');
            filename = $(button).data('filename');

            $('#deleteFileEvidenceText').text(`Apakah anda yakin ingin menghapus file evidence ${filename}?`);
            $('#deleteFileEvidenceId').val(id_evidence);

            $('#deleteEvidence').modal('show');
        }

        function downloadEvidence(button) {
            id_evidence = $(button).data('id');
            filename = $(button).data('filename');

            const data = { id_evidence: id_evidence };

            fetch(`{{ route('evidence.download') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                return response.blob();
            })
            .then(blob => {
                toastr.success('Evidence download successfully.');

                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            })
            .catch(error => {
                toastr.error('Failed to download file.');
            });
        }
    </script>
@endpush
