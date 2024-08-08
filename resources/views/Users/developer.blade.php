@extends('layouts.auth')
@push('css')
    <link rel="stylesheet" href="{{asset('components/css/developer.css')}}">
@endpush
@section('title', 'Developer Page')
@section('content')
<div class="container-dev">
<div style="--total:5" class="circle-wrapper">
    <div class="center-elemental">The Team</div>

    <input type="radio" name="radio-avatar" id="radio-avatar-1">
    <label id="avatar-1" for="radio-avatar-1" class="avatar" style="--i:1">
        <img src="{{asset('components/assets/face/azzello.jpg')}}" alt="Azzello Fabian Cristoper A.K.A Ello">
        <svg viewBox="0 0 300 300">
            <text fill="currentColor">
                <textPath xlink:href="#circlePath">Azzello Fabian Cristoper A.K.A Ello - Web Frontend</textPath>
            </text>
        </svg>
    </label>

    <input type="radio" name="radio-avatar" id="radio-avatar-2">
    <label id="avatar-2" for="radio-avatar-2" class="avatar" style="--i:2">
        <img src="{{asset('components/assets/face/rifaa.jpg')}}" alt="Muhammad Rifaa Siraajuddin Sugandi A.K.A KnowRise">
        <svg viewBox="0 0 300 300">
            <text fill="currentColor">
                <textPath xlink:href="#circlePath">Muhammad Rifaa Siraajuddin .S A.K.A KnowRise - Web Backend</textPath>
            </text>
        </svg>
    </label>

    <input type="radio" name="radio-avatar" id="radio-avatar-3">
    <label id="avatar-3" for="radio-avatar-3" class="avatar" style="--i:3">
        <img src="{{asset('components/assets/face/hilal.jpg')}}" alt="Muhamad Hilal A.K.A M1zaru">
        <svg viewBox="0 0 300 300">
            <text fill="currentColor">
                <textPath xlink:href="#circlePath">Muhamad Hilal A.K.A M1zaru - Backend API System</textPath>
            </text>
        </svg>
    </label>

    <input type="radio" name="radio-avatar" id="radio-avatar-4">
    <label id="avatar-4" for="radio-avatar-4" class="avatar" style="--i:4">
        <img src="{{asset('components/assets/face/nadhif.jpg')}}" alt="Nadhif Musyafa Alfarel A.K.A TreeAngel">
        <svg viewBox="0 0 300 300">
            <text fill="currentColor">
                <textPath xlink:href="#circlePath">Nadhif Musyafa Alfarel A.K.A TreeAngel - Android Developer</textPath>
            </text>
        </svg>
    </label>

    <input type="radio" name="radio-avatar" id="radio-avatar-5">
    <label id="avatar-5" for="radio-avatar-5" class="avatar" style="--i:5">
        <img src="{{asset('components/assets/face/bintang.jpg')}}" alt="Bintang Akbar Ramadhan A.K.A Biboo">
        <svg viewBox="0 0 300 300">
            <text fill="currentColor">
                <textPath xlink:href="#circlePath">Bintang Akbar Ramadhan A.K.A Biboo - Desktop Developer</textPath>
            </text>
        </svg>
    </label>
</div>

<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 300 300" width="0" height="0">
    <defs>
        <path id="circlePath" d="M 150, 150 m -100, 0 a 100,100, 0 0,1 200,0 a 100,100 0 0,1 -200,0" />
    </defs>
</svg>
</div>
@endsection
@push('js')
<script src="{{asset('components/js/developer.js')}}"></script>
@endpush
