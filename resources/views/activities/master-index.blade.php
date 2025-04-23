<!-- resources/views/your-view.blade.php -->

@extends('master/master')

@section('title', 'Master Data - Activity')

@section('activity', 'active')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Card untuk tampilan yang lebih baik -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Aktivitas</h3>
                        <div class="card-tools">
                            <a href="{{ route('activities.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Tambah Aktivitas
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Mengirim data activities ke komponen -->
                        <x-table-component />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
