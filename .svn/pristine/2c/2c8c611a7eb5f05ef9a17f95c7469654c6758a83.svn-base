@extends('master/master')

@section('title', 'Dashboard Direktorat Operasional')

@section('dash', 'active')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <form action="/dash_data" method="GET">
        <div class="form-row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="dropdown1">Pilih Data:</label>
              <select class="form-control" id="unit" name="unit">
                <option value="1">PTPN I</option>
                <option value="2">Direktorat Keuangan dan Manajemen Risiko</option>
                <option value="3" selected>Direktorat Operasional</option>
                <option value="4">Direktorat SDM dan TI</option>
                <option value="5">Direktorat Pemasaran dan Manajemen Aset</option>
                <option value="6">Direktorat Hubungan Kelembagaan</option>
                <option value="7">Regional 1</option>
                <option value="8">Regional 2</option>
                <option value="9">Regional 3</option>
                <option value="10">Regional 4</option>
                <option value="11">Regional 5</option>
                <option value="12">Regional 6</option>
                <option value="13">Regional 7</option>
                <option value="14">Regional 8</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="dropdown2">Pilih Tahun:</label>
              <select class="form-control" id="tahun" name="tahun">
                <option value="2024" selected>2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
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
    <!-- isi tabel data -->
    <!-- isi tabel data -->
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
              <div class="row">
                <div class="col-md-12">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">A. Nilai Ekonomi dan Sosial Untuk Indonesia</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card card-outline card-secondary collapsed-card">
                                  <div class="card-header">
                                    <h3 class="card-title">A1. Finansial</h3>

                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                      </button>
                                    </div>
                                    <!-- /.card-tools -->
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <div class="container">
                                      <table id="table_a1" class="table_data table table-bordered table-responsive">
                                        <thead>
                                          <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Key Performance Indicator</th>
                                            <th rowspan="2">Formula Indicator</th>
                                            <th rowspan="2">ESG</th>
                                            <th rowspan="2">88 PS</th>
                                            <th rowspan="2">Satuan</th>
                                            <th rowspan="2">Target*</th>
                                            <th rowspan="2">Polaritas</th>
                                            <th colspan="2">Bobot</th>
                                          </tr>
                                          <tr>
                                            <th>Sub</th>
                                            <th>Total</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>1</td>
                                            <td>EBITDA</td>
                                            <td>EBITDA</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>Rp. Miliar</td>
                                            <td>1.356,45</td>
                                            <td>Maximize</td>
                                            <td>8</td>
                                            <td rowspan="5">40</td>
                                          </tr>
                                          <tr>
                                            <td>2</td>
                                            <td>ROIC >= WACC</td>
                                            <td>ROIC - WACC</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>(6,57)</td>
                                            <td>Maximize</td>
                                            <td>8</td>
                                            <td></td>
                                          </tr>
                                          <tr>
                                            <td>3</td>
                                            <td>Interest Bearing Debt to EBITDA</td>
                                            <td>Interest Bearing Debt to EBITDA</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>Kali</td>
                                            <td>12,93</td>
                                            <td>Minimize</td>
                                            <td>8</td>
                                            <td></td>
                                          </tr>
                                          <tr>
                                            <td>4</td>
                                            <td>Interest Bearing Debt to Invested Capital</td>
                                            <td>Interest Bearing Debt : (Ekuitas+Interest Bearing Debt)</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>39,61</td>
                                            <td>Minimize</td>
                                            <td>8</td>
                                            <td></td>
                                          </tr>
                                          <tr>
                                            <td>5</td>
                                            <td>Cash Flow from Operational</td>
                                            <td>Cash Flow from Operational</td>
                                            <td>G</td>
                                            <td>-</td>
                                            <td>Rp. Miliar</td>
                                            <td>(459,39)</td>
                                            <td>Maximize</td>
                                            <td>8</td>
                                            <td></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card card-outline card-secondary collapsed-card">
                                  <div class="card-header">
                                    <h3 class="card-title">A2. Operasional</h3>

                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                      </button>
                                    </div>
                                    <!-- /.card-tools -->
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <div class="container">
                                      <div class="container">
                                        <table id="table_a1" class="table_data table table-bordered table-responsive">
                                          <thead>
                                            <tr>
                                              <th rowspan="2">No.</th>
                                              <th rowspan="2">Key Performance Indicator</th>
                                              <th rowspan="2">Formula Indicator</th>
                                              <th rowspan="2">ESG</th>
                                              <th rowspan="2">88 PS</th>
                                              <th rowspan="2">Satuan</th>
                                              <th rowspan="2">Target*</th>
                                              <th rowspan="2">Polaritas</th>
                                              <th colspan="2">Bobot</th>
                                            </tr>
                                            <tr>
                                              <th>Sub</th>
                                              <th>Total</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>1</td>
                                              <td>Indeks Produktivitas Tebu</td>
                                              <td>(Produksi Tebu : Total Areal) x Persentase Pendapatan</td>
                                              <td>C</td>
                                              <td>-</td>
                                              <td>%</td>
                                              <td>1,632</td>
                                              <td>Maximize</td>
                                              <td>7</td>
                                              <td rowspan="4">26</td>
                                            </tr>
                                            <tr>
                                              <td>2</td>
                                              <td>Indeks Produktivitas Karet Kering</td>
                                              <td>(Produksi Karet Kering : Total Areal) x Persentase Pendapatan</td>
                                              <td>C</td>
                                              <td>-</td>
                                              <td>%</td>
                                              <td>0,525</td>
                                              <td>Maximize</td>
                                              <td>7</td>
                                              <td></td>
                                            </tr>
                                            <tr>
                                              <td>3</td>
                                              <td>Indeks Produktivitas Teh Kering</td>
                                              <td>(Produksi Teh Kering : Total Areal) x Persentase Pendapatan</td>
                                              <td>C</td>
                                              <td>-</td>
                                              <td>%</td>
                                              <td>0,249</td>
                                              <td>Maximize</td>
                                              <td>6</td>
                                              <td></td>
                                            </tr>
                                            <tr>
                                              <td>4</td>
                                              <td>Indeks Produktivitas Kopi</td>
                                              <td>(Produksi Kopi : Total Areal) x Persentase Pendapatan</td>
                                              <td>C</td>
                                              <td>-</td>
                                              <td>%</td>
                                              <td>0,009</td>
                                              <td>Maximize</td>
                                              <td>6</td>
                                              <td></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card card-outline card-secondary collapsed-card">
                                  <div class="card-header">
                                    <h3 class="card-title">A3. Sosial</h3>

                                    <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                      </button>
                                    </div>
                                    <!-- /.card-tools -->
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <div class="container">
                                      Data kosong
                                    </div>
                                  </div>
                                  <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">B. Inovasi Model Bisnis</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="container">
                              <table id="table_b" class="table_data table table-bordered table-responsive">
                                <thead>
                                  <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Key Performance Indicator</th>
                                    <th rowspan="2">Formula Indicator</th>
                                    <th rowspan="2">ESG</th>
                                    <th rowspan="2">88 PS</th>
                                    <th rowspan="2">Satuan</th>
                                    <th rowspan="2">Target*</th>
                                    <th rowspan="2">Polaritas</th>
                                    <th colspan="2">Bobot</th>
                                  </tr>
                                  <tr>
                                    <th>Sub</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>Penataan komposisi tanaman melalui replanting/konversi/Kerja Sama</td>
                                    <td>Jumlah areal (Selesai Tanam) Tebu Plant Cane (PC) + Jumlah areal (Selesai Tanam) komoditi karet + Jumlah areal (Selesai Tanam) kopi</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Ha</td>
                                    <td>13.803</td>
                                    <td>Maximize</td>
                                    <td>7</td>
                                    <td>7</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">C. Kepemimpinan Teknologi</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="container">
                              <div class="container">
                                <table id="table_a1" class="table_data table table-bordered table-responsive">
                                  <thead>
                                    <tr>
                                      <th rowspan="2">No.</th>
                                      <th rowspan="2">Key Performance Indicator</th>
                                      <th rowspan="2">Formula Indicator</th>
                                      <th rowspan="2">ESG</th>
                                      <th rowspan="2">88 PS</th>
                                      <th rowspan="2">Satuan</th>
                                      <th rowspan="2">Target*</th>
                                      <th rowspan="2">Polaritas</th>
                                      <th colspan="2">Bobot</th>
                                    </tr>
                                    <tr>
                                      <th>Sub</th>
                                      <th>Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>1</td>
                                      <td>Pemanfaatan digitalisasi dan teknologi untuk kegiatan On-Farm (Implementasi Automation Weather Station (AWS))</td>
                                      <td>Jumlah Unit yang diimplementasikan di PTPN I</td>
                                      <td>C</td>
                                      <td>-</td>
                                      <td>Unit</td>
                                      <td>6</td>
                                      <td>Maximize</td>
                                      <td>6</td>
                                      <td rowspan="2">12</td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td>Pemanfaatan digitalisasi dan teknologi untuk kegiatan Off-Farm (Indicator Monitoring System)</td>
                                      <td>Jumlah Unit yang mengimplementasikan IOT di PTPN I</td>
                                      <td>C</td>
                                      <td>-</td>
                                      <td>%</td>
                                      <td>11,29</td>
                                      <td>Maximize</td>
                                      <td>6</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">D. Peningkatan Investasi</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="container">
                              <table id="table_d" class="table_data table table-bordered table-responsive">
                                <thead>
                                  <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Key Performance Indicator</th>
                                    <th rowspan="2">Formula Indicator</th>
                                    <th rowspan="2">ESG</th>
                                    <th rowspan="2">88 PS</th>
                                    <th rowspan="2">Satuan</th>
                                    <th rowspan="2">Target*</th>
                                    <th rowspan="2">Polaritas</th>
                                    <th colspan="2">Bobot</th>
                                  </tr>
                                  <tr>
                                    <th>Sub</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody <tr>
                                  <td>1</td>
                                  <td>Investasi Pabrik Teh Hijau</td>
                                  <td>Investasi Pabrik Teh Hijau di PTPN I</td>
                                  <td>C</td>
                                  <td>-</td>
                                  <td>Rp. Miliar</td>
                                  <td>10</td>
                                  <td>Maximize</td>
                                  <td>5</td>
                                  <td rowspan="2">10</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Realisasi PMN</td>
                                    <td>1. Realisasi Penyerapan PMN <br> 2. Realisasi Progres Fisik PMN</td>
                                    <td>S</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100</td>
                                    <td>Maximize</td>
                                    <td>5</td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">E. Pengembangan Talenta</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="container">
                              Data Kosong
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                  </div>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-outline card-secondary collapsed-card">
                          <div class="card-header">
                            <h3 class="card-title">F. Turunan dari Arahan Taktis 2024</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="container">

                              <table id="table_b" class="table_data table table-bordered table-responsive">
                                <thead>
                                  <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Key Performance Indicator</th>
                                    <th rowspan="2">Formula Indicator</th>
                                    <th rowspan="2">ESG</th>
                                    <th rowspan="2">88 PS</th>
                                    <th rowspan="2">Satuan</th>
                                    <th rowspan="2">Target*</th>
                                    <th rowspan="2">Polaritas</th>
                                    <th colspan="2">Bobot</th>
                                  </tr>
                                  <tr>
                                    <th>Sub</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>Transformasi EBITDA</td>
                                    <td>Pelaksanaan Inisiatif Program Transformasi EBITDA di Subholding</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100</td>
                                    <td>Maximize</td>
                                    <td>5</td>
                                    <td>5</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
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