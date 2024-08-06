<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Wedding</title>
    <style>
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            text-align: center;
        }

        .disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body>
    {{-- <h1>Ini add Wedding {{ $type }}</h1> --}}
    {{-- <form action="{{ route('add.wedding') }}">
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
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </form> --}}
    <h1>Create Your Custom Wedding</h1>
    <form action="{{ route('post.wedding', $type) }}" method="POST">
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
            <div>
                @foreach ($categories as $category)
                    <div>
                        @csrf
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
                                        <img src="{{ asset($attachment->image_path) }}" alt="{{ $vendor->name }}"
                                            width="200">
                                    </div>
                                    <input type="radio" value="{{ $vendor->id }}"
                                        name="{{ $category->name . '_id' }}">
                                @else
                                    <p>No attachments available</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit">Save Custom Wedding</button>
            </div>
        @endif
    </form>

    <script>
        function selectItem(category, itemId) {
            const items = document.querySelectorAll(`[data-id^="${category}"]`);
            items.forEach(item => item.classList.remove('disabled'));

            document.querySelector(`[data-id="${itemId}"]`).classList.add('disabled');
        }
    </script>
</body>

</html>
