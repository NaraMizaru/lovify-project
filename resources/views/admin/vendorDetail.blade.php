@extends('layouts.app-admin')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/admin/vendor-detail.css') }}">
@endpush
@section('title', 'Admin')

@section('content')

    <h1>Ini Detail Vendor {{ $vendor->name }}</h1>
    <p>Number Phone: {{ $vendor->number_phone }}</p>
    <p>Number Phone: {{ $vendor->bank_number }}</p>
    @if ($vendor->category->name == 'catering')
        <p>Quantity{{ $vendor->qty }}</p>
    @endif
    <p>{{ $vendor->price }}</p>
    <p>{{ $vendor->fee }}</p>
    <p>{{ $vendor->total_price }}</p>
    <p>{{ $vendor->description }}</p>
    @if ($vendor->category->name == 'venue')
        <p>{{ $vendor->total_guest }}</p>
        <p>{{ $vendor->address }}</p>
    @endif

    @push('js')

    @endpush
    @endsection
