@extends('layouts.app-admin')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/admin/dasboard.css') }}">
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@endpush
@section('title', 'Admin')
@section('content')
    <h1>Daftar Vendor</h1>
    <table id="vendorTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Biaya</th>
                <th>Total Harga</th>
                <th>Alamat</th>
                <th>Total Tamu</th>
                <th>Jumlah</th>
                <th>Nomor Telepon</th>
                <th>Nomor Rekening</th>
                <th>Kategori</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ number_format($vendor->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($vendor->fee, 0, ',', '.') }}</td>
                    <td>{{ number_format($vendor->total_price, 0, ',', '.') }}</td>
                    @if ($vendor->category->name == 'venue')
                        <td>{{ $vendor->address }}</td>
                        <td>{{ $vendor->total_guest }}</td>
                        <td>-</td>
                    @elseif ($vendor->category->name == 'catering')
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $vendor->qty }}</td>
                    @else
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                    <td>{{ $vendor->phone_number }}</td>
                    <td>{{ $vendor->bank_number }}</td>
                    <td>{{ ucfirst($vendor->category->name) }}</td>
                    <td><a href="{{ route('vendor.detail', $vendor) }}" class="btn btn-sm btn-primary">Detail</a></td>
                    <td>
                        <form action="{{ route('vendor.delete', $vendor) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @push('js')
        <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#vendorTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                    }
                });
            });
        </script>
    @endpush
@endsection
