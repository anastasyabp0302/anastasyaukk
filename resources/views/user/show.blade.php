<DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{{ $user->name }}'s Photos</title>
</head>
<body>

@if($user)
    <h1>{{ $user->name }}'s Photos</h1>
@else
    <p> User not found </p>
@endif
    <div class="photos">
        @foreach($photos as $photo)
        <div class="photo">
            <img src="{{ $photo->url }}" alt="{{ $photo->description }}" width="300">
            <p>{{ $photo->description }}</p>
</div>
@endforeach
</div>
@endif

</body>
</html>