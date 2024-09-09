@extends('master/master')

@push('css')
    <style>
        .form-container {
            border-radius: 10px;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            background: #e9ecef;
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }

        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        /* Select2 customization */
        .select2-selection__choice {
            background-color: #007bff !important;
            color: white !important;
        }

        .select2-container .select2-selection--multiple {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
        }

        .select2-container .select2-selection--single {
            width: 100% !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('title', 'Create Data KPI')

@section('kpi', 'active')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-default mr-3">
                    <div class="card-body">
                        <div class="form-container">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item w-50">
                                    <a class="nav-link active" id="form1-tab" data-toggle="tab" role="tab"
                                        aria-controls="form1" aria-selected="true">KPI</a>
                                </li>
                                <li class="nav-item w-50">
                                    <a class="nav-link" id="form2-tab" data-toggle="tab" role="tab"
                                        aria-controls="form2" aria-selected="false">DISTRIBUSI</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-4" id="myTabContent">
                                <div class="tab-pane fade show active" id="form1" role="tabpanel"
                                    aria-labelledby="form1-tab">
                                    <form id="kpiForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama-kpi">Nama KPI:</label>
                                            <textarea class="form-control" name="nama-kpi" id="nama-kpi" rows="3" required></textarea>
                                            <div class="invalid-feedback" id="nama-kpiError"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="formula-kpi">Formula KPI:</label>
                                            <textarea class="form-control" name="formula-kpi" id="formula-kpi" rows="3" required></textarea>
                                            <div class="invalid-feedback" id="formula-kpiError"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="esg">ESG:</label>
                                            <input type="text" class="form-control" id="esg" name="esg"
                                                required>
                                            <div class="invalid-feedback" id="esgError"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="satuan">Satuan:</label>
                                            <select class="form-control" id="satuan" name="satuan" required>
                                                @foreach ($satuans as $satuan)
                                                    <option value="{{ $satuan->kpi_satuan_id }}">
                                                        {{ $satuan->kpi_satuan_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="segment">Perspektif :</label>
                                            <select class="form-control" id="segment" name="segment" required>
                                                @foreach ($segments as $segment)
                                                    <option value="{{ $segment->kpi_master_data_kpi_segmen_id }}">
                                                        {{ $segment->kpi_master_data_kpi_segmen_global }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="subSegment">Sub Perspektif :</label>
                                            <select class="form-control" id="subSegment" name="subSegment" required>
                                                @foreach ($subSegments as $subSegment)
                                                    <option value="{{ $subSegment->kpi_master_data_kpi_subsegmen_id }}">
                                                        {{ $subSegment->kpi_master_data_kpi_subsegmen_judul }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="polaritas">Polaritas:</label>
                                            {{-- <input type="text" class="form-control" id="polaritas" name="polaritas"
                                                required> --}}
                                            <select class="form-control" name="polaritas" id="polaritas" required>
                                                <option value="Maximal">Maximal</option>
                                                <option value="Minimal">Minimal</option>
                                            </select>
                                            <div class="invalid-feedback" id="polaritasError"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahun">Tahun : </label>
                                            {{-- <input type="number" class="form-control" name="tahun" id="tahun"
                                                step="1" min="1900" max="2099" value="{{ date('Y') }}"
                                                required> --}}
                                            <select name="tahun" id="tahun" class="form-control">
                                                @for ($i = date('Y'); $i <= date('Y') + 5; $i++)
                                                    @if ($i == date('Y'))
                                                        <option value="{{ $i }}" selected>{{ $i }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback" id="tahunError"></div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-primary px-4" id="nextBtn">Next</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="form2" role="tabpanel" aria-labelledby="form2-tab">
                                    <div class="kpi-info">
                                        <h5>Nama KPI : <span id="nama-kpi-value" class="text-bold"></span></h5>
                                        <h5>Formula KPI : <span id="formula-kpi-value" class="text-bold"></span></h5>
                                        <h5>ESG : <span id="esg-value" class="text-bold"></span></h5>
                                        <h5>Satuan : <span id="satuan-value" class="text-bold"></span></h5>
                                        <h5>Perspektif : <span id="segment-value" class="text-bold"></span></h5>
                                        <h5>Sub Perspektif : <span id="subSegment-value" class="text-bold"></span></h5>
                                    </div>

                                    <form id="distribusiForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="container-fluid" id="collapseContainer">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="card card-outline card-secondary collapsed-card">
                                                            <div class="card-header">
                                                                <h3 class="card-title" id="distribusi-title">-</h3>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        onclick="removeCollapse(this)" id="btnRemove">
                                                                        <i class="fas fa-trash"
                                                                            style="color: #800000"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="target">Target 1 Tahun:</label>
                                                                            <input type="number" type="0.01"
                                                                                class="form-control" id="target"
                                                                                name="distribusi[0][target]" required>
                                                                            <div class="invalid-feedback"
                                                                                id="distribusi[0][target]Error"></div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="bobot">Target Skor
                                                                                (Bobot):</label>
                                                                            <input type="number" class="form-control"
                                                                                id="bobot" name="distribusi[0][bobot]"
                                                                                required>
                                                                            <div class="invalid-feedback"
                                                                                id="distribusi[0][bobot]Error"></div>
                                                                        </div>
                                                                        <hr class="mt-4 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="pemilik_utama">Direktorat /
                                                                                Regional
                                                                                :</label>
                                                                            <select class="form-control"
                                                                                id="pemilik_utama"
                                                                                name="distribusi[0][pemilik_utama]"
                                                                                required>
                                                                                @foreach ($bagians as $bagian)
                                                                                    <option
                                                                                        value="{{ $bagian->kpi_master_bagian_id }}">
                                                                                        {{ $bagian->kpi_master_bagian_nama }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"
                                                                                id="distribusi[0][pemilik_utama]Error">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="pemilik_lainnya">Viewer
                                                                                :</label>
                                                                            <select class="form-control"
                                                                                id="pemilik_lainnya_0"
                                                                                name="distribusi[0][pemilik_lainnya][]"
                                                                                multiple required>
                                                                                @foreach ($bagians as $bagian)
                                                                                    <option
                                                                                        value="{{ $bagian->kpi_master_bagian_id }}">
                                                                                        {{ $bagian->kpi_master_bagian_nama }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"
                                                                                id="distribusi[0][pemilik_lainnya]Error">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="petugas">Editor :</label>
                                                                            <select class="form-control select2-0"
                                                                                id="petugas_0"
                                                                                name="distribusi[0][petugas][]" multiple
                                                                                required>
                                                                                @foreach ($bagians as $bagian)
                                                                                    <option
                                                                                        value="{{ $bagian->kpi_master_bagian_id }}">
                                                                                        {{ $bagian->kpi_master_bagian_nama }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"
                                                                                id="distribusi[0][petugas]Error"></div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="container-fluid">
                                                    <div class="col-md-12">
                                                        <button type="button" id="addMore"
                                                            class="d-flex flex-row py-2 border border-primary rounded w-100 bg-white">
                                                            <div class="ml-2 px-1 mr-4">
                                                                <i class="fas fa-plus text-blue"></i>
                                                            </div>
                                                            <div class="text-blue text-bold">
                                                                add more
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-success" id="submitBtn">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let collapseCounter = 0;

        function moreCollapse() {
            collapseCounter++;
            let newCollapse = `
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-secondary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title" id="distribusi-title">-</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick="removeCollapse(this)"
                                    id="btnRemove">
                                    <i class="fas fa-trash"
                                        style="color: #800000"></i>
                                </button>
                                <button type="button" class="btn btn-tool"
                                    data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="target">Target 1 Tahun:</label>
                                        <input type="number" type="0.01"
                                            class="form-control" id="target"
                                            name="distribusi[${collapseCounter}][target]" required>
                                        <div class="invalid-feedback"
                                            id="distribusi[${collapseCounter}][target]Error">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bobot">Target Skor (Bobot):</label>
                                        <input type="number" class="form-control"
                                            id="bobot" name="distribusi[${collapseCounter}][bobot]"
                                            required>
                                        <div class="invalid-feedback"
                                            id="distribusi[${collapseCounter}][bobot]Error">
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-3">
                                    <div class="form-group">
                                        <label for="pemilik_utama">Direktorat / Regional :</label>
                                        <select class="form-control select2-${collapseCounter}"
                                            id="pemilik_utama"
                                            name="distribusi[${collapseCounter}][pemilik_utama]"
                                            required>
                                            @foreach ($bagians as $bagian)
                                                <option
                                                    value="{{ $bagian->kpi_master_bagian_id }}">
                                                    {{ $bagian->kpi_master_bagian_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"
                                            id="distribusi[${collapseCounter}][pemilik_utama]Error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pemilik_lainnya">Viewer :</label>
                                        <select class="form-control"
                                            id="pemilik_lainnya_${collapseCounter}"
                                            name="distribusi[${collapseCounter}][pemilik_lainnya][]" multiple
                                            required>
                                            @foreach ($bagians as $bagian)
                                                <option
                                                    value="{{ $bagian->kpi_master_bagian_id }}">
                                                    {{ $bagian->kpi_master_bagian_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"
                                            id="distribusi[${collapseCounter}][pemilik_lainnya]Error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="petugas">Editor :</label>
                                        <select class="form-control"
                                            id="petugas_${collapseCounter}"
                                            name="distribusi[${collapseCounter}][petugas][]" multiple
                                            required>
                                            @foreach ($bagians as $bagian)
                                                <option
                                                    value="{{ $bagian->kpi_master_bagian_id }}">
                                                    {{ $bagian->kpi_master_bagian_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"
                                            id="distribusi[${collapseCounter}][petugas]Error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return newCollapse;
        }

        function removeCollapse(button) {
            collapseCounter--;
            $(button).closest('.col-md-12').remove();
        }

        function getNameById(array, id, idField, nameField) {
            for (var i = 0; i < array.length; i++) {
                if (array[i][idField] == id) {
                    return array[i][nameField];
                }
            }
            return null;
        }

        function initializationSelect2() {
            for (let index = 0; index <= collapseCounter; index++) {
                $('#pemilik_lainnya_' + index).select2({
                    placeholder: "Pilih Viewer",
                    allowClear: true,
                });
                $('#petugas_' + index).select2({
                    placeholder: "Pilih Editor",
                    allowClear: true,
                });
            }
        }

        $(document).ready(function() {
            $('#form1-tab').click(function() {
                if (!$('#form1-tab').hasClass('active')) {
                    $('#form1-tab').addClass('active');
                    $('#form2-tab').removeClass('active');
                    $('#form1').addClass('active show');
                    $('#form2').removeClass('active show');
                }
            });
            $('#form2-tab').click(function() {
                if (!$('#form2-tab').hasClass('active')) {
                    $('#form2-tab').addClass('active');
                    $('#form1-tab').removeClass('active');
                    $('#form2').addClass('active show');
                    $('#form1').removeClass('active show');
                }
            })
            $('#nextBtn').click(function() {
                var isValid = true;
                $('#kpiForm input, #kpiForm select, #kpiForm textarea').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                })
                if (!isValid) {
                    alert('Please fill out all required fields.');
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('kpi.storeKpi') }}",
                    data: $('#kpiForm').serialize(),
                    success: function(response) {
                        console.log(response);
                        var formData = $('#kpiForm').serializeArray();
                        formData.forEach(item => {
                            if (item.name === 'satuan') {
                                $('#' + item.name + '-value').text(getNameById(
                                    @json($satuans),
                                    item
                                    .value,
                                    'kpi_satuan_id', 'kpi_satuan_nama'));
                            } else if (item.name === 'segment') {
                                $('#' + item.name + '-value').text(getNameById(
                                    @json($segments), item
                                    .value,
                                    'kpi_master_data_kpi_segmen_id',
                                    'kpi_master_data_kpi_segmen_global'));
                            } else if (item.name === 'subSegment') {
                                $('#' + item.name + '-value').text(getNameById(
                                    @json($subSegments), item
                                    .value,
                                    'kpi_master_data_kpi_subsegmen_id',
                                    'kpi_master_data_kpi_subsegmen_judul'));
                            } else {
                                $('#' + item.name + '-value').text(item.value);
                            }
                            // $('#id-kpi-value').text(response.kpiId);
                        });
                        $('#form1-tab').removeClass('active');
                        $('#form2-tab').addClass('active');
                        $('#form2').addClass('active show');
                        $('#form1').removeClass('active show');
                        $('#form1-tab').addClass('disabled');
                        $('#form2-tab').click();
                        $('#form1-tab').click(function(e) {
                            e.preventDefault(); // Prevent going back to Form 1
                        });
                        console.log(response.kpiId);

                        $('#distribusiForm').append(
                            `<input type="hidden" name="kpiId" value="${response.kpiId}">`
                        );
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        if (xhr.status === 422) { // Status 422 menunjukkan validation error
                            var errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                var value = errors[key];
                                alert(value);
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + 'Error').text(value[
                                    0]); // Menampilkan error message
                            });
                        } else {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    }
                })
            });

            $('#pemilik_lainnya_0').select2({
                placeholder: "Pilih Viewer",
                allowClear: true,
            });
            $('#petugas_0').select2({
                placeholder: "Pilih Editor",
                allowClear: true,
            });

            $(document).on('change', '#pemilik_utama', function() {
                var selectedTexts = $(this).find('option:selected').map(function() {
                    return $(this).text();
                }).get();

                $(this).closest('.card').find('.card-title').text(selectedTexts);
            });

            // add more collapse
            $('#addMore').click(function() {
                var newElement = $(moreCollapse());
                $('#collapseContainer').append(newElement);
                initializationSelect2();
            });

            $('#submitBtn').click(function() {
                console.log('hallo');
                var data = $('#distribusiForm').serializeArray();
                console.log(data);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('kpi.storeDistribusi') }}",
                    data: $('#distribusiForm').serialize(),
                    success: function(response) {
                        // console.log(response);
                        toastr.success(response['message']);
                        // alert(response['message']);
                        window.location.href = "{{ route('kpi.index') }}";
                    },
                    error: function(xhr, status, error) {
                        // Log the entire xhr object to see what it contains
                        // console.log(xhr);

                        if (xhr.status === 422) { // Status 422 menunjukkan validation error
                            var response = xhr.responseJSON ||
                            {}; // Ensure responseJSON is defined
                            var errors = response.errors || {}; // Ensure errors is defined
                            Object.keys(errors).forEach(function(key) {
                                var value = errors[key];
                                // console.log(value);
                                // Menampilkan error message dengan Toastr
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + 'Error').text(value[
                                    0]); // Menampilkan error message di form
                            });
                            toastr.error(response['message']);
                        } else {
                            var responseText = xhr.responseText || 'An error occurred.';
                            toastr.error('An error occurred: ' + responseText);
                        }
                    }
                })
            });
        });
    </script>
@endpush
