<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($attachments as $attachment)
        <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}">
    @endforeach
    <h1>{{ $vendor->name }}</h1>
    @if ($vendor->category->name == 'venue')
        <p>Address: {{ $vendor->address }}</p>
        <p>Max Guest: {{ $vendor->total_guest }}</p>
    @endif
    <p>Price: {{ $vendor->total_price }}</p>
    <p>{{ $vendor->description }}</p>
</body>
</html>
