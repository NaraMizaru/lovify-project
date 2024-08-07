<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Ini Detail Vendor {{ $vendor->name }}</h1>
    <p>Number Phone: {{ $vendor->number_phone }}</p>
    <p>Number Phone: {{ $vendor->bank_number }}</p>
    @if ($vendor->category->name == 'catering')
        <p>Quantity{{ $vendor->qty }}</p>
    @endif
    <p>{{ $vendor->price }}</p>
    <p>{{ $vendor->fee }}</p>
    <p>{{ $vendor->total_price }}</p>
    <p>{{ $vendor->description }}</p>
    @if ($vendor->category->name == 'venue')
        <p>{{ $vendor->total_guest }}</p>
        <p>{{ $vendor->address }}</p>
    @endif
</body>
</html>
