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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <script>
        let progressTable;
        let pieChartInstance;

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
                    { data: 'no', name: 'no', orderable: false, searchable: false },
                    { data: 'proyek', name: 'proyek' },
                    { data: 'scope', name: 'scope' },
                    { data: 'activity', name: 'activity' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            let color = '#007BFF'; // Default: On Schedule

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
                            response['Project Overdue Belum Mulai'],
                            response['Project Akan Overdue'],
                            response['Project on Schedule']
                        ]);
                    }
                });
            }
            $('#filter-year').change(function () {
                progressTable.ajax.reload(); 
                loadPieChartData();          
            });
        });

        // Fungsi update Pie Chart
        function updatePieChart(dataValues) {
            const ctx = document.getElementById('pieChartProject').getContext('2d');

            const dataPie = {
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        '#dc3545',  
                        '#ffc107',  
                        '#28a745',  
                        '#007BFF'   
                    ],
                    borderWidth: 1
                }],
                labels: [
                    'Project Overdue Penyelesaian',
                    'Project Overdue Belum Mulai',
                    'Project Akan Overdue',
                    'Project On Schedule'
                ]
            };

            if (pieChartInstance) pieChartInstance.destroy();

            pieChartInstance = new Chart(ctx, {
                type: 'pie',
                data: dataPie,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>


@endsection