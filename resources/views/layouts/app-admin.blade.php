<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://naramizaru.github.io/awesome/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('components/assets/icon-web.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('components/css/admin/style.css') }}">

    @stack('css')

</head>

<body>
    @include('Template.sidebar-admin')
    @yield('content')
</body>
@stack('js')

</html>
