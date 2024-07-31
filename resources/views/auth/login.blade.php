@extends('layouts.auth')
@push('css')
    <link rel="stylesheet" href="{{ asset('components/css/login.css') }}">
@endpush
@section('title', 'Login')
@section('content')
<div class="container">
<div class="card">
<form action="{{route('post.login')}}" method="POST">
    @csrf

    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <input type="text" required>
                <label>Username/Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" required>
                <label>Password</label>
            </div>

            <button type="submit" class="btn">Login</button>
            <div class="login-register">
                <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
            </div>
        </div>
    </div>
</form>
</div>
</div>
@endsection
