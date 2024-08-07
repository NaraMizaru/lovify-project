@extends('layouts.app-admin')
@push('css')
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('components/css/admin/dasboard.css') }}">
@endpush
@section('title', 'Admin')
ini wedding
@section('content')
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>User</th>
                <th>Name</th>
                <th>Price</th>
                <th>Custom Id</th>
                <th>packet Id</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($weddings as $wedding)
                <tr>
                    <td>{{ $wedding->user->name }}</td>
                    <td>{{ $wedding->name }}</td>
                    <td>{{ $wedding->name }}</td>
                    <td>{{ $wedding->price }}</td>
                    <td>{{ $wedding->packet->id }}</td>
                    <td>{{ $wedding->packetCustom->id }}</td>
                    <td><a href="">Detail</a></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @push('js')
        <script>
            new DataTable('#example');
        </script>
        <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    @endpush
@endsection
