@extends('master/master')

@section('title', 'Dashboard Regional 6')

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
                <option value="3">Direktorat Operasional</option>
                <option value="4">Direktorat SDM dan TI</option>
                <option value="5">Direktorat Pemasaran dan Manajemen Aset</option>
                <option value="6">Direktorat Hubungan Kelembagaan</option>
                <option value="7">Regional 1</option>
                <option value="8">Regional 2</option>
                <option value="9">Regional 3</option>
                <option value="10">Regional 4</option>
                <option value="11">Regional 5</option>
                <option value="12"selected>Regional 6</option>
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
                                            <td>710,15</td>
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
                                            <td>13,02</td>
                                            <td>Maximize</td>
                                            <td>8</td>
                                          </tr>
                                          <tr>
                                            <td>3</td>
                                            <td>Interest Bearing Debt to EBITDA</td>
                                            <td>Interest Bearing Debt to EBITDA</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>Kali</td>
                                            <td>0,0038</td>
                                            <td>Minimize</td>
                                            <td>8</td>
                                          </tr>
                                          <tr>
                                            <td>4</td>
                                            <td>Interest Bearing Debt to Invested Capital</td>
                                            <td>Interest Bearing Debt : (Ekuitas+Interest Bearing Debt)</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>0,0545</td>
                                            <td>Minimize</td>
                                            <td>8</td>
                                          </tr>
                                          <tr>
                                            <td>5</td>
                                            <td>Cash Flow from Operational</td>
                                            <td>Cash Flow from Operational</td>
                                            <td>G</td>
                                            <td>-</td>
                                            <td>Rp. Miliar</td>
                                            <td>12,55</td>
                                            <td>Maximize</td>
                                            <td>8</td>
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
                                            <td>2,523</td>
                                            <td>Maximize</td>
                                            <td>3</td>
                                            <td rowspan="1">3</td>
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
                                            <td>Realisasi Program TJSL BUMN</td>
                                            <td>Realisasi Program CID TJSL BUMN</td>
                                            <td>S</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>100</td>
                                            <td>Maximize</td>
                                            <td>3</td>
                                            <td rowspan="1">3</td>
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
                                    <td>665</td>
                                    <td>Maximize</td>
                                    <td>3</td>
                                    <td rowspan="3">9</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Integrasi Grup Usaha PTPN III (Persero)</td>
                                    <td>1. Penyelesaian Nilai Buku dan PPh Final (30%) <br> 2. Proses BPHTB 0% (Nol Persen) (30%) <br> 3. Pengambilalihan Saham SugarCo (40%)</td>
                                    <td>G</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100</td>
                                    <td>Minimize</td>
                                    <td>3</td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Implementasi Roadmap Perbaikan Penerapan Manajemen Risiko</td>
                                    <td>(Jumlah Program yang Dilaksanakan Tahun 2024 : Total Program Roadmap Perbaikan Penerapan Manajemen Risiko) x 100%</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100</td>
                                    <td>Maximize</td>
                                    <td>3</td>
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
                              Data kosong
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
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>Monetisasi dan/atau Pelepasan aset non-inti</td>
                                    <td>Nilai yang diperoleh dari Pelepasan Aset PTPN</td>
                                    <td>G</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>800</td>
                                    <td>Maximize</td>
                                    <td>3</td>
                                    <td>3</td>
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