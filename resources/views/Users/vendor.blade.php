@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/vendor.css') }}">
@endpush
@section('title', 'Landing Page')
@section('content')
    <div class="container-slider">
        {{-- CATERING --}}
        <div class="box">
            @foreach ($categories as $category)
                <div class="box-name-vendor">
                    <h2 class="text">{{ $category->name }}</h2>
                </div>
                <div class="slider">
                    <div class="slider-track">
                        @foreach ($vendors->where('category_id', $category->id) as $vendor)
                            <div class="slide">
                                <a href="#" target="_blank">
                                    @php
                                        $VendorAttachments = $attachments->get($vendor->id, collect());
                                        $attachment = $VendorAttachments->first();
                                    @endphp
                                    @if ($VendorAttachments->isNotEmpty())
                                        <img src="{{ asset($attachment->image_path) }}" alt="">
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- SAMA --}}

    {{-- <div class="slide">
                <a href="https://www.axiooworld.com/" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="#" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="https://www.axiooworld.com/" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="#" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="https://www.axiooworld.com/" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="#" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="https://www.axiooworld.com/" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                </a>
            </div>
            <div class="slide">
                <a href="#" target="_blank">
                    <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                </a>
            </div>
        </div>
    </div>
    </div> --}}
    {{-- DECORATION --}}
    {{-- <div class="box">
        <div class="box-name-vendor">
            <h2 class="text">DECORATION</h2>
        </div>
        <div class="slider">
            <div class="slider-track">
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div> --}}

    {{-- SAMA --}}

    {{-- <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- MUA --}}
    {{-- <div class="box">
        <div class="box-name-vendor">
            <h2 class="text">MUA</h2>
        </div>
        <div class="slider">
            <div class="slider-track">
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div> --}}

    {{-- SAMA --}}

    {{-- <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- Photographer --}}
    {{-- <div class="box">
        <div class="box-name-vendor">
            <h2 class="text">PHOTOGRAPHER</h2>
        </div>
        <div class="slider">
            <div class="slider-track">
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div> --}}

    {{-- SAMA --}}

    {{-- <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- VENUE --}}
    {{-- <div class="box">
        <div class="box-name-vendor">
            <h2 class="text">VENUE</h2>
        </div>
        <div class="slider">
            <div class="slider-track">
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div> --}}

    {{-- SAMA --}}

    {{-- <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="https://www.axiooworld.com/" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/axio.png') }}" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="#" target="_blank">
                        <img src="{{ asset('components/assets/sponsor/gojek.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- END --}}
    {{-- </div>
    </div> --}}

@endsection
