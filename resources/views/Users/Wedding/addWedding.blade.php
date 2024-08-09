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
    <form action="{{ route('add.post.wedding') }}" method="POST">
        @csrf
        <label for="name">Name: </label>
        <input type="text" name="name" id="name">
        <label for="date">Date: </label>
        <input type="date" name="date" id="date">
        <div>
            <label>Choose Packet: </label>
            <div>
                <input type="radio" name="type" value="custom">
                <label for="type">Custom</label>
            </div>
            <div>
                <input type="radio" name="type" value="packet">
                <label for="type">Packet</label>
            </div>
        </div>
        <button type="submit">Create</button>
    </form>
</body>

</html>
