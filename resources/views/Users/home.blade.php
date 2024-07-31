@extends('layouts.app')
@section('title', 'Lovify')

@section('content')
    @auth
        <a href="{{ route('logout') }}">Logout</a>
    @endauth
@endsection
