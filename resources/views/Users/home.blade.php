@extends('layouts.app-2')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/home.css') }}">
@endpush
@section('title', 'Lovify')

@section('content')

    @foreach ($categories as $category)
        <div>
            <h2>{{ $category->name }}</h2>
            <div>
                @foreach ($vendors as $vendor)
                    @if ($vendor->category_id == $category->id)
                        <div>
                            @foreach ($attachments as $attachment)
                                @if ($attachment->vendor_id == $vendor->id)
                                    <img src="{{ asset($attachment->image_path) }}" alt="" width="200">
                                @endif
                            @endforeach
                            <h3>{{ $vendor->name }}</h3>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach

    @push('js')
        <script src="{{ asset('components/js/sidebar.js') }}"></script>
    @endpush
@endsection
