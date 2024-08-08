@extends('layouts.app-2')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/home.css') }}">
@endpush
@section('title', 'Lovify')

@section('content')
    @foreach ($categories as $category)
        <div>
            <h2>{{ $category->name }}</h2>
            @foreach ($vendors->where('category_id', $category->id) as $vendor)
                <div>
                    @php
                        $vendorAttachments = $attachments->get($vendor->id, collect());
                    @endphp
                    @if ($vendorAttachments->isNotEmpty())
                        @php
                            $attachment = $vendorAttachments->first();
                        @endphp
                        <h3>{{ $vendor->name }}</h3>
                        <div>
                            <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}" width="200">
                            <p>{{ $vendor->total_price }}</p>
                            @if ($vendor->category->name == 'vanue')
                                <p>Address: {{ $vendor->address }}</p>
                                <p>Total Guest: {{ $vendor->total_guest }}</p>
                            @elseif ($vendor->category->name == 'catering')
                                <p>Jumlah: {{ $vendor->qty }}++</p>
                            @endif
                            <a href="{{ route('vendor.detail', $vendor) }}">Detail</a>
                        </div>
                    @else
                        <p>No attachments available</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach



    @push('js')
        <script src="{{ asset('components/js/sidebar.js') }}"></script>
    @endpush
@endsection
