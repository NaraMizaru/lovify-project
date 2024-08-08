@extends('layouts.app-admin')
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('components/css/admin/dasboard.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('DataTables/datatables.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" /> --}}
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('components/css/admin/vendor.css')}}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
@endpush
@section('title', 'Admin')
@section('content')
<div class="container-table">
    <div class="box-name-table">
    <h1>Daftar Vendor</h1>
    <table id="myTable" class="display text-white" style="width:100%;">
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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendors as $vendor)
                <tr id="tr-vendor">
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
                    <td>{{ $vendor->number_phone }}</td>
                    <td>{{ $vendor->bank_number }}</td>
                    <td>{{ ucfirst($vendor->category->name) }}</td>
                    <td><a href="{{ route('vendor.detail', $vendor) }}" class="btn btn-sm btn-primary" id="btn-detail-vendor">Detail</a></td>
                    <td>
                        <form action="{{ route('vendor.delete', $vendor) }}" method="POST" onsubmit="return submitForm(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="btn-delete-vendor">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    {{-- <script src="{{ asset('DataTables/datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#vendorTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
        });
    </script> --}}
    <script src="{{asset('components/js/admin/sweetalert.min.js')}}"></script>
    <script>
         function submitForm(form) {
        swal({
            title: "Are you sure?",
            text: "This form will be submitted",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then(function (isOkay) {
            if (isOkay) {
                form.submit();
            }
        });
        return false;
    }
    </script>

@endpush
