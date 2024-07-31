@extends('layouts.auth')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/register.css') }}">
@endpush
@section('title, Register')
@section('content')
<div class="container">
    <div class="card">
        <form action="{{route('post.register')}}" method="POST">
        @csrf

        <div class="wrapper">
            <div class="form-box login">
                <h2>Register</h2>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" required>
                    <label>Full Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" required>
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" required>
                    <label>Confirm Password</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" required>
                    <label>Phone Number</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Login</a></p>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
