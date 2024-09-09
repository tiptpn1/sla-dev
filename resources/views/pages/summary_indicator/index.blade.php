@extends('master/master')

@section('title', 'Summary Indicator')

@section('summary', 'active')

@section('content')
    <section class="content">
        <div class="container-fluid">
            {{-- Search Form --}}
            <div class="container-fluid">
                <form action="{{ route('summary-indicator.search') }}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="kpiId">Pilih Indicator :</label>
                                <select class="form-control" id="kpiId" name="kpiId">
                                    @foreach ($kpis as $kpi)
                                        <option value="{{ $kpi->id }}"
                                            @if ($kpi_id == $kpi->id) selected @endif>{{ $kpi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">Pilih Tahun:</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bulan">Pilih Bulan:</label>
                                <select class="form-control" id="bulan" name="bulan">
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}"
                                            @if ($key == $bulan) selected @endif>{{ $month }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-secondary btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- End Search Form --}}

            {{-- Table --}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-default">
                            <div class="card-header">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <row>
                                    <div class="col-md-12">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outline card-secondary">
                                                        <div class="card-body">
                                                            <div class="container">
                                                                <table
                                                                    class="table_data table table-bordered table-responsive">
                                                                    <thead>
                                                                        <tr>
                                                                            <th rowspan="3">
                                                                                No.</th>
                                                                            <th rowspan="3">
                                                                                Divisi / Regional</th>
                                                                            <th rowspan="3">
                                                                                Key
                                                                                Performance
                                                                                Indicator
                                                                            </th>
                                                                            <th rowspan="3">
                                                                                Formula
                                                                                Indicator
                                                                            </th>
                                                                            <th rowspan="3">
                                                                                ESG</th>
                                                                            <th rowspan="3">
                                                                                PS</th>
                                                                            <th rowspan="3">
                                                                                Satuan
                                                                            </th>
                                                                            <th rowspan="3">
                                                                                Polaritas
                                                                            </th>
                                                                            <th colspan="7">
                                                                                Corporate
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Realisasi</th>
                                                                            <th colspan="2">Target RKAP</th>
                                                                            <th rowspan="2">Target Skor (Bobot)</th>
                                                                            <th rowspan="2">Skor Realisasi / Target
                                                                                {{ $months[$bulan] }}
                                                                                {{ $tahun }}</th>
                                                                            <th rowspan="2">Skor Realisasi/ Target
                                                                                {{ $tahun }}
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>S.d. Bulan ini</th>
                                                                            <th>S.d. {{ $months[$bulan] }}
                                                                                {{ $tahun }}</th>
                                                                            <th>1 Tahun</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($query as $index => $data)
                                                                            <tr>
                                                                                <td>{{ $index + 1 }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_bagian_nama }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_data_kpi_nama }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_data_kpi_formula }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_data_kpi_esg ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_data_kpi_ps ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_satuan_nama ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_master_data_kpi_polaritas ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_monitoring_realisasi ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_monitoring_rkap_bulan_ini ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_distribusi_kpi_target ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_distribusi_kpi_bobot ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_monitoring_realisasi_target_bulanan ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $data->kpi_monitoring_realiasai_target_tahun ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </row>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </section>
@endsection
