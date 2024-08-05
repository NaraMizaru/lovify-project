@extends('layouts.app-2')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/home.css') }}">
@endpush
@section('title', 'Lovify')

@section('content')

    @push('js')
        <script src="{{ asset('components/js/sidebar.js') }}"></script>
    @endpush
@endsection
