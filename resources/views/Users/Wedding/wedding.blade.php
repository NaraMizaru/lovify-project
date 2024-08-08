<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wedding</title>
</head>
<body>
    <a href="{{ route('add.wedding') }}">Add Wedding</a>
    @foreach ($weddings as $wedding)
        <p>{{ $wedding->name }}</p>
    @endforeach
</body>
</html>
