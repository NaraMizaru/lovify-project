@extends('layouts.app-admin')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/admin/dasboard.css') }}">
@endpush
@section('title', 'Admin')

@section('content')
<div class="container-dashboard">
    <div class="box-content-dashboard">
        <h2 class="h2-admin">DASHBOARD</h2>
    </div>

    <div class="container-info">
        <div class="box-wedding">
            <div class="box-icon">
                <i></i>
            </div>
            <div class="box-text-info-wedding-vendor">
                <p>JUMLAH WEDDING :</p>
                <h4>100</h4>
            </div>
            <div class="btn-a">
                <a href="{{route('wedding-admin')}}">
                    <span class="spana"></span>
                    <span class="spana"></span>
                    <span class="spana"></span>
                    <span class="spana"></span>
                    OPEN
                </a>
            </div>
        </div>
        <div class="box-vendor">
            <div class="box-icon">
                <i></i>
            </div>
            <div class="box-text-info-wedding-vendor">
                <p>JUMLAH VENDOR :</p>
                <h4>300</h4>
            </div>
            <div class="btn-a">
                <a href="#">
                    <span class="spana"></span>
                    <span class="spana"></span>
                    <span class="spana"></span>
                    <span class="spana"></span>
                    OPEN
                </a>
            </div>
        </div>
    </div>
</div>

@push('js')

@endpush
@endsection
