<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Detail</title>
</head>
<body>
    <h1>{{ $vendor->name }}</h1>
    <p>Category: {{ $vendor->category->name }}</p>
    <p>Price: {{ $vendor->price }}</p>

    @if($attachments->isNotEmpty())
        <h2>Images:</h2>
        @foreach($attachments as $attachment)
            <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}" width="200">
        @endforeach
    @endif
</body>
</html>
