@extends('master/master')

@section('title', 'Dashboard Monitoring Program Kerja')

@section('dashboard', 'active')

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="mb-3">
                <button class="btn btn-danger" data-toggle="modal" data-target="#reportPdfModal" hidden>
                    <i class="fas fa-file-pdf mr-2"></i>
                    Report PDF Progress
                </button>
                <button class="btn btn-success" data-toggle="modal" data-target="#reportExcelModal">
                    <i class="fas fa-file-excel mr-2"></i>
                    Report Excel Progress
                </button>
            </div>
        </div>

        <x-progress-activity />

        <div class="col-md-12">
            <div class="card mt-4 mb-4 w-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="font-weight-bold">Progress Overview by Gantt Chart</h4>
                </div>
                <div class="card-body" id="gantt-chart-field">
                    @if(count($projects) > 0)
                        <div id="gantt_here" style="width:100%; height:500px;"></div>
                    @else
                        <div class="alert alert-info">
                            Tidak ada proyek yang tersedia untuk ditampilkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="reportPdfModal" tabindex="-1" role="dialog" aria-labelledby="reportPdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportPdfModalLabel">Pilih Tahun dan Proyek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="GET">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Tahun -->
                        <div class="form-group">
                            <label for="year">Pilih Tahun Progress</label>
                            <select name="year" id="year" class="form-control">
                                @for ($i = now()->year; $i <= now()->year + 5; $i++)
                                    <option value="{{ $i }}" @if (now()->year == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Pilih Proyek -->
                        <div class="form-group">
                            <label for="project">Pilih Proyek</label>
                            <select name="project" id="project" class="form-control">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->project_id }}">{{ $project->project_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <span class="text-muted text-sm">*Report berupa PDF dengan data activity</span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Download Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reportExcelModal" tabindex="-1" role="dialog" aria-labelledby="reportPdfModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportPdfModalLabel">Pilih Tahun dan Proyek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.download-excel') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Tahun -->
                        <div class="form-group">
                            <label for="year">Pilih Tahun Progress</label>
                            <select name="year" id="year" class="form-control">
                                @for ($i = now()->year; $i <= now()->year + 5; $i++)
                                    <option value="{{ $i }}" @if (now()->year == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Pilih Proyek -->
                        <div class="form-group">
                            <label for="project">Pilih Proyek</label>
                            <select name="project" id="project" class="form-control">
                                <option value="0" selected>Semua Proyek</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id_project }}">{{ $project->project_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <span class="text-muted text-sm">*Report berupa Excel dengan data activity</span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Download Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('ganchart') }}',
                method: 'GET',
                success: function(response) {
                    $('#gantt-chart-field').html(response);
                }
            })

            $('#reportPdfForm').on('submit', function(e) {
                e.preventDefault(); // Prevent normal form submission

                var year = $('#year').val();
                var projectId = $('#project').val();
                var projectName = $('#project option:selected').data('name'); // Get project name
                var randomNum = Math.floor(Math.random() * 100000); // Generate random number

                // AJAX request to generate the PDF
                $.ajax({
                    url: '{{ route('dashboard.download-pdf') }}',
                    method: 'GET',
                    data: {
                        year: year,
                        project: projectId
                    },
                    xhrFields: {
                        responseType: 'blob' // Handle binary data for file download
                    },
                    success: function(response) {
                        var blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'report_' + projectName + '_' + year + '_' + randomNum +
                            '.pdf';
                        link.click();

                        // Close the modal after successful download
                        $('#reportPdfModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to generate report. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
