@extends('master/master')

@section('title', 'Dashboard Regional 2')

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
                <option value="8" selected>Regional 2</option>
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
                                            <td>(18,38)</td>
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
                                            <td>(16,14)</td>
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
                                            <td>(0,99)</td>
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
                                            <td>0,39</td>
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
                                            <td>(263,24)</td>
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
                                            <td>Indeks Produktivitas Karet Kering</td>
                                            <td>(Produksi Karet Kering : Total Areal) x Persentase Pendapatan</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>0,241</td>
                                            <td>Maximize</td>
                                            <td>3</td>
                                            <td rowspan="2">6</td>
                                          </tr>
                                          <tr>
                                            <td>2</td>
                                            <td>Indeks Produktivitas Teh Kering</td>
                                            <td>(Produksi Teh Kering : Total Areal) x Persentase Pendapatan</td>
                                            <td>C</td>
                                            <td>-</td>
                                            <td>%</td>
                                            <td>1,326</td>
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
                                    <td>Integrasi Grup Usaha PTPN III (Persero)</td>
                                    <td>"1. Penyelesaian Nilai Buku dan PPh Final (30%)
                                      2. Proses BPHTB 0% (Nol Persen) (30%)
                                      3. Pengambilalihan Saham SugarCo (40%)"</td>
                                    <td>G</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100</td>
                                    <td>Minimize</td>
                                    <td>3</td>
                                    <td rowspan="2">6</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
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
                                    <td>613,83</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                    <td>2</td>
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
                                    <td>Rasio Top Talent Muda (<=42 tahun) dalam Nominated Talent</td>
                                    <td>Jumlah Talenta Muda (<=42 Tahun) dalam Nominated Talent : Total Nominated Talent</td>
                                    <td>S</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>18</td>
                                    <td>Maximize</td>
                                    <td>3</td>
                                    <td rowspan="3">9</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Rasio Perempuan dalam Nominated Talent</td>
                                    <td>Jumlah Talenta Perempuan dalam Nominated Talent : Total Nominated Talent</td>
                                    <td>S</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>18</td>
                                    <td>Maximize</td>
                                    <td>3</td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Implementasi Roadmap Penyehatan Dana Pensiun</td>
                                    <td>Jumlah iuran tambahan, piutang payment dan iuran normal pemberi kerja</td>
                                    <td>G</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>5,29</td>
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
                                    <td>Inventory Turnover</td>
                                    <td>(Inventory : COGS) * 365</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Hari</td>
                                    <td>84</td>
                                    <td>Minimize</td>
                                    <td>2</td>
                                    <td rowspan="16">34</td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Equity to Total Asset</td>
                                    <td>Equity to Total Asset</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>43,13</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Rancangan RKAP</td>
                                    <td>Penyusunan Rancangan Rencana Kerja dan Anggaran Perusahaan tahun 2025</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Waktu</td>
                                    <td>31 Okt 2024</td>
                                    <td>Minimize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>LM Bulanan</td>
                                    <td>Penerbitan Laporan Manajemen Setiap Bulan Berjalan</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Waktu</td>
                                    <td>setiap tanggal 5 bulan berikutnya</td>
                                    <td>Minimize</td>
                                    <td>3</td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>Transaksi Pengadaan Barang/Jasa dengan Penyedia UMKM melalui PaDi UMKM</td>
                                    <td>Nilai Transaksi Pengadaan Barang/Jasa dengan Penyedia UMKM melalui PaDi UMKM</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>18,50</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>6</td>
                                    <td>Penggunaan Produk Dalam Negeri (PDN)</td>
                                    <td>Nilai Belanja Penggunaan Produk Dalam Negeri (PDN) PTPN Grup</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>341,90</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>7</td>
                                    <td>Efesiensi Nilai SPPBJ dibandingkan HPS</td>
                                    <td>Persentase efesiensi nilai SPPBJ dibandingkan HPS</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>3,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>8</td>
                                    <td>Reviu Perikatan, Peraturan Perusahaan dan Pengkajian/ Pendapat Hukum</td>
                                    <td>Terlaksananya Reviu Perikatan, PeraturanPerusahaan dan Pengkajian/ Pendapat Hukum sesuai dengan standar yang telah ditetapkan perusahaan</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>100,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>9</td>
                                    <td>Penyelesaian Perkara Pertanahan Di Pengadilan</td>
                                    <td>Jumlah luasan tanah objek sengketa yang di putus menang dibanding luas keseluruhan sengketa yang yang telah diputus inkracht</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>75,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>10</td>
                                    <td>Recovery Aset</td>
                                    <td>Penertiban aset untuk dapat memberikan benefit kepada perusahaan</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Ha</td>
                                    <td>350,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>11</td>
                                    <td>Penerbitan surat oleh Pemerintah Daerah terkait tarif 0% BPHTB</td>
                                    <td>Persentase jumlah surat yang diterbitkan oleh Pemerintah Daerah dibanding dengan total target surat Pemerintah Daerah terkait tarif 0% BPHTB</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>75,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>12</td>
                                    <td>Survei Kepuasan Stakeholder</td>
                                    <td>Persentase index score hasil survey kepuasan Stakeholder</td>
                                    <td>S</td>
                                    <td>-</td>
                                    <td>%</td>
                                    <td>75,00</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>13</td>
                                    <td>Pencapaian nilai penjualan retail</td>
                                    <td>Nilai penjualan berdasarkan rencana gula retail, kopi dan teh di 2024</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>61,62</td>
                                    <td>Maximize</td>
                                    <td>3</td>
                                  </tr>
                                  <tr>
                                    <td>14</td>
                                    <td>Kerjasama Pemanfaatan Aset Non Core</td>
                                    <td>Pendapatan Kerjasama Aset Non Core Tahun 2024</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>83,40</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>15</td>
                                    <td>Sertifikasi Aset Tanah (Permohonan Baru dan/atau Perpanjangan/ Pembaruan)</td>
                                    <td>Terbit SK dan/atau Sertifikat Hak atas Tanah PTPN Group</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Ha</td>
                                    <td>7.777,23</td>
                                    <td>Maximize</td>
                                    <td>2</td>
                                  </tr>
                                  <tr>
                                    <td>16</td>
                                    <td>Peningkatan nilai penjualan produk teh premium kebun model Malabar Group dan Wonosari</td>
                                    <td>Peningkatan nilai penjualan produk teh premium kebun model sub unit Malabar dibanding tahun 2023</td>
                                    <td>C</td>
                                    <td>-</td>
                                    <td>Rp. Miliar</td>
                                    <td>4</td>
                                    <td>Maximize</td>
                                    <td>2</td>
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