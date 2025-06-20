@extends('master/master')

@section('title', 'Project Overdue Monitoring Program Kerja')

@section('overdue', 'active')

@push('css')
    <style>
        .btn-edit {
            background-color: transparent !important;
            border: none !important;
            color: #ffa500 !important;
        }
        .btn-edit:hover {
            color: #cc8400 !important;
        }
        .btn-delete {
            background-color: transparent !important;
            border: none !important;
            color: #dc3545 !important;
        }
        .btn-delete:hover {
            color: #bd2130 !important;
        }
        .table th,
        .table td {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }
        .table-rounded thead th:first-child {
            border-top-left-radius: 8px !important;
        }
        .table-rounded thead th:last-child {
            border-top-right-radius: 8px !important;
        }
        .table-rounded tbody tr:last-child td:first-child {
            border-bottom-left-radius: 8px !important;
        }
        .table-rounded tbody tr:last-child td:last-child {
            border-bottom-right-radius: 8px !important;
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
        }
        .pagination-left,
        .pagination-center,
        .pagination-right {
            display: flex;
            align-items: center;
        }
        .pagination-center {
            justify-content: center;
        }
        .pagination-right {
            justify-content: flex-end;
        }
        #per-page {
            width: 80px;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">
@endpush

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="card mt-4 mb-4 w-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="font-weight-bold">Project Overdue by Pie Chart</h4> 
                </div>
                <div class="card-body">
                    <!-- Card for pie chart -->
                    <div class="d-flex justify-content-center">
                        <div style="width: 330px; height: 330px;">
                            <canvas id="pieChartProject" width="250" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
        <div class="col-md-12">
            <div class="card mt-4 mb-4 w-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="font-weight-bold">Rincian Project Overdue </h4> 
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="filter-year">Filter Tahun:</label>
                        <select id="filter-year" class="form-control" style="width: 200px; display: inline-block;">
                            @for ($i = 2023; $i <= now()->year + 1; $i++)
                                <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- Card for table -->
                    <div class="table-responsive">
                        <table id="progress-table" class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Divisi</th>
                                    <th>Sub Divisi</th>
                                    <th>Nama Aktivitas</th>
                                    <th>Status Overdue</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
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
    </section>

    <script>
        let progressTable;
        let pieChartInstance;

        const hakAkses = {{ session('hak_akses_id') }};
        const isSubDiv = {{ session('id_sub_divisi') != null ? 'true' : 'false' }};

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Inisialisasi DataTable
            progressTable = $('#progress-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('overdue.data') }}",
                    data: function (d) {
                        d.year = $('#filter-year').val();
                    }
                },
                columns: [
                    { 
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                    },
                    { data: 'project' },
                    { data: 'scope' },
                    { data: 'activity' },
                    {
                        data: 'status',
                        render: function (data) {
                            let color = '';
                            if (data.includes('Belum Mulai')) {
                                color = '#ffc107'; // Kuning
                            } else if (data.includes('Penyelesaian')) {
                                color = '#dc3545'; // Merah
                            } else if (data.includes('Akan Overdue')) {
                                color = '#28a745'; // Hijau
                            }

                            return `
                                <span class="badge"
                                    style="
                                        margin: 2px;
                                        padding: 5px 10px;
                                        background-color: ${color};
                                        color: white;
                                        border-radius: 15px;
                                        cursor: default;">
                                    ${data}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'keterangan',
                        render: function (data, type, row, meta) {
                            const canEdit = hakAkses == 7;
                            return `
                                <textarea 
                                    class="edit form-control ${canEdit ? 'bg-secondary text-white' : 'bg-light'}"
                                    data-id="${row.id_activity}"
                                    data-field="keterangan"
                                    ${canEdit ? '' : 'disabled'}
                                >${data ?? ''}</textarea>
                            `;
                        }
                    },
                    {
                        data: 'status2',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            const canEdit = hakAkses == 7;
                                if (canEdit && !data) {
                                    return `
                                        <button class="btn btn-warning btn-sm status2-btn" data-id="${row.id_activity}" style="font-weight: 700;">
                                            Tindak Lanjuti
                                        </button>
                                    `;
                                } else if (data) {
                                    return `<strong class="text-success">Sudah ditindaklanjuti</strong>`;
                                } else {
                                    return `<strong class="text-danger">Belum ditindaklanjuti</strong>`;
                                }

                            return '';
                        }
                    }
                ]
            });

            progressTable.on('xhr', function () {
                loadPieChartData(); // ambil data chart semua proyek
            });

            function loadPieChartData() {
                $.ajax({
                    url: "{{ route('overdue.chart') }}",
                    method: 'GET',
                    data: {
                        year: $('#filter-year').val()
                    },
                    success: function (response) {
                        updatePieChart([
                            response['Project Overdue Penyelesaian'],
                            response['Project Overdue Belum Mulai Realisasi'],
                            response['Project Akan Overdue']
                        ]);
                    }
                });
            }
            $('#filter-year').change(function () {
                progressTable.ajax.reload(); 
                loadPieChartData();          
            });
        });

        //Keterangan
        $(document).on('change', '.edit', function () {
            const id = $(this).data('id');
            const field = $(this).data('field');
            const value = $(this).val();

            $.ajax({
                url: '/update-keterangan',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_activity: id,
                    field: field,
                    value: value
                },
                success: function (response) {
                    toastr.success(response.message);
                    var data = response.data;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });

        //Button Tindak Lanjut
        $(document).on('click', '.status2-btn', function () {
            const id = $(this).data('id');
            const button = $(this);

            Swal.fire({
                title: 'Konfirmasi',
                text: "Yakin ingin menindaklanjuti aktivitas ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tindak lanjuti!',
                cancelButtonText: 'Tidak'           
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/overdue/status",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function (res) {
                            if (res.success) {
                                // Ganti tampilan tombol
                                const cell = button.closest('td');
                                cell.html('<strong class="text-success">Sudah ditindaklanjuti</strong>');

                                // Reload badge 
                                fetch("{{ route('overdue.count') }}")
                                    .then(response => response.json())
                                    .then(data => {
                                    const badge = document.getElementById('overdue-badge');
                                    if (data.count > 0) {
                                        badge.textContent = data.count;
                                        badge.style.display = 'inline-block';
                                    } else {
                                        badge.style.display = 'none';
                                    }
                                });
                                //Reload chart
                                if (typeof loadChartData === 'function') {
                                    loadChartData();
                                }
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Aktivitas telah ditindaklanjuti.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Gagal menindaklanjuti aktivitas.',
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Server error atau koneksi gagal.',
                            });
                        }
                    });
                }
            });
        });

        // Fungsi update Pie Chart
        function updatePieChart(dataValues) {
            const ctx = document.getElementById('pieChartProject').getContext('2d');

            const dataPie = {
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        '#dc3545',  // Merah
                        '#ffc107',  // Kuning
                        '#28a745',  // Hijau
                    ],
                    borderWidth: 1
                }],
                labels: [
                    `Project Overdue Penyelesaian: ${dataValues[0]}`,
                    `Project Overdue Belum Mulai Realisasi: ${dataValues[1]}`,
                    `Project Akan Overdue: ${dataValues[2]}`
                ],
            };

            if (pieChartInstance) pieChartInstance.destroy();

            pieChartInstance = new Chart(ctx, {
                type: 'pie',
                data: dataPie,
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                const label = data.labels[tooltipItem.index] || '';
                                const value = data.datasets[0].data[tooltipItem.index] || 0;
                                return `${label}`;
                            }
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: '#ffff',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            formatter: function (value, context) {
                                if (value === 0) return '';
                                return value;
                            }
                        }
                    }
                }
            });
        }

        function loadChartData() {
            fetch("{{ route('overdue.chart') }}")
                .then(res => res.json())
                .then(data => {
                    updatePieChart([
                        data["Project Overdue Penyelesaian"],
                        data["Project Overdue Belum Mulai"],
                        data["Project Akan Overdue"]
                    ]);
                });
        }
    </script>


@endsection