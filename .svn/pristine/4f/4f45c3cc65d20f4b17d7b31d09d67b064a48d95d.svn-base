@extends('master/master')

@section('title', 'Data KPI - ' . $kpi->kpi_master_data_kpi_nama)

@section('kpi', 'active')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-default-mr-3">
                    <div class="card-body">
                        <div class="kpi-info">
                            <h5>Nama KPI : <span id="nama-kpi-value"
                                    class="text-bold">{{ $kpi->kpi_master_data_kpi_nama }}</span></h5>
                            <h5>Formula KPI : <span id="formula-kpi-value"
                                    class="text-bold">{{ $kpi->kpi_master_data_kpi_formula }}</span></h5>
                            <h5>ESG : <span id="esg-value" class="text-bold">{{ $kpi->kpi_master_data_kpi_esg }}</span></h5>
                            <h5>Satuan : <span id="satuan-value" class="text-bold">{{ $kpi->satuan_name }}</span></h5>
                            <h5>Perspektif : <span id="segment-value" class="text-bold">{{ $kpi->segment_name }}</span></h5>
                            <h5>Sub Perspektif : <span id="subSegment-value"
                                    class="text-bold">{{ $kpi->sub_segment_name }}</span></h5>
                        </div>
                        <div class="kpi-dist">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="container-fluid">
                                        @foreach ($distribusi as $index => $dist)
                                            <div class="col-md-12 mb-3">
                                                <div class="card card-outline card-secondary collapsed-card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">{{ $dist['pemilik_utama_name'] }}

                                                        </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table
                                                                    class="table table-striped table-hover table-bordered">
                                                                    <thead class="">
                                                                        <tr>
                                                                            <th>Data</th>
                                                                            <th>Keterangan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Target 1 Tahun:</td>
                                                                            <td>{{ $dist['target'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Target Skor (Bobot):</td>
                                                                            <td>{{ $dist['bobot'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Direktorat / Regional :</td>
                                                                            <td>{{ $dist['pemilik_utama_name'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Viewer :</td>
                                                                            <td>
                                                                                <ul class="list-unstyled">
                                                                                    @foreach ($dist['pemilik'] as $pemilik)
                                                                                        <li>{{ $pemilik['pemilik_bagian_name'] }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Editor:</td>
                                                                            <td>
                                                                                <ul class="list-unstyled">
                                                                                    @foreach ($dist['petugas'] as $pemilik)
                                                                                        <li>{{ $pemilik['petugas_bagian_name'] }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
