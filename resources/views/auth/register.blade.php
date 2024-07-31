@extends('layouts.auth')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/register.css') }}">
@endpush

@section('title', 'Register')
@section('content')
    <div class="container">
        <div class="card">
            <form action="{{ route('post.register') }}" method="POST">
                @csrf

                <div class="wrapper">
                    <div class="form-box login">
                        <h2>Register</h2>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" required name="fullname">
                            <label>Full Name</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" required name="username">
                            <label>Username</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" required name="email">
                            <label>Email</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" required name="password">
                            <label>Password</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" required name="password_confirmation">
                            <label>Confirm Password</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" required name="number_phone">
                            <label>Phone Number</label>
                        </div>
                        <button type="submit" class="btn">Register</button>
                        <div class="login-register">
                            <p>Have an Account? <a href="{{ route('login') }}" class="register-link">Login</a></p>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p style="color: red">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
