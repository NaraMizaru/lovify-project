@extends('layouts.app-2')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/profile.css') }}">
@endpush
@section('title', 'Profile')

@section('content')

    @push('js')
        <script src="{{ asset('components/js/sidebar.js') }}"></script>
    @endpush
@endsection
