<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Lofivy')</title>
    <link rel="stylesheet" href="https://naramizaru.github.io/awesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('components/css/Nav.css') }}">
    <link rel="stylesheet" href="{{ asset('components/css/style.css') }}">
</head>

<body>
    @include('Template.Nav')
</body>

</html>
