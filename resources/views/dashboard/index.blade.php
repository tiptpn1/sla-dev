@extends('master/master')

@section('title', 'Dashboard SLA')

@section('dashboard', 'active')

@section('content')
    <section class="content">
        <x-progress-activity />
    </section>
@endsection
