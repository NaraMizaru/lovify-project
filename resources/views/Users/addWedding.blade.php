<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Wedding</title>
</head>

<body>
    <h1>Ini add Wedding {{ $type }}</h1>
    <form action="{{ route('add.wedding') }}">
        @csrf
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" required>
        <label for="date">Date: </label>
        <input type="date" name="date" id="date">
        @if ($type == 'Packet')
            @foreach ($packets as $packet)
                <select name="packet_id" id="packet_id">
                    <option value="{{ packet->id }}">{{ packet->name }}</option>
                </select>
            @endforeach
        @elseif ($type == 'Custom')
            @foreach ($categories as $category)
                <div>
                    <h2>{{ $category->name }}</h2>
                    @foreach ($vendors->where('category_id', $category->id) as $vendor)
                        <div>
                            <h3>{{ $vendor->name }}</h3>
                            @php
                                $vendorAttachments = $attachments->get($vendor->id, collect());
                            @endphp
                            @if ($vendorAttachments->isNotEmpty())
                                @php
                                    $attachment = $vendorAttachments->first();
                                @endphp
                                <div>
                                    <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}" width="200">
                                </div>
                            @else
                                <p>No attachments available</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </form>
</body>

</html>
