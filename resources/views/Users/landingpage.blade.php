@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('components/css/landingpage.css')}}">
@endpush
@section('title', 'Landing Page')
@section('content')
<div class="container">
    <div class="box">
        <div class="img">
            <img src="{{asset('components/assets/transparant-black.png')}}" alt="">
        </div>
        <div class="button">
            <a href="#" class="btn">Book Now</a>
        </div>
    </div>
</div>
@endsection
