<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Ini Custom</h1>
    @foreach ($categories as $category)
        <div>
            <h1>{{ $category->name }}</h1>
            <div>
                @foreach ($vendors->where('category_id', $category->id) as $vendor)
                    @php
                        $vendorAttachments = $attachments->get($vendor->id, collect());
                    @endphp
                    @if ($vendorAttachments->isNotEmpty())
                        @php
                            $attachment = $vendorAttachments->first();
                        @endphp
                        <h1>{{ $vendor->name }}</h1>
                        <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}" width="500">
                        <p>Price: {{ number_format($vendor->total_price, 0, ',', '.') }}</p>
                        @if ($vendor->category->name == 'venue')
                            <p>Address: {{ $vendor->address }}</p>
                            <p>Total Guest: {{ $vendor->total_guest }}</p>
                        @elseif ($vendor->category->name == 'catering')
                            <p>Jumlah: {{ $vendor->qty }}</p>
                        @endif
                        <a href="{{ route('choose.detail.custom.wedding', [$wedding, $custom, $vendor]) }}">Detail</a>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</body>

</html>
