@extends('layouts.app-admin')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/admin/dasboard.css') }}">
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('components/css/admin/vendor.css')}}">
    <link rel="stylesheet" href="cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
@endpush
@section('title', 'Admin')
@section('content')
<div class="container-table">
    <div class="box-name-table">
    <h1>Daftar Vendor</h1>
    </div>
<div class="box-table">
    <table id="myTable" class="display" style="width:100%;">
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
</div>
</div>
    @push('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
        <script>
            let table = new DataTable('#myTable')
        </script>
    @endpush
@endsection
