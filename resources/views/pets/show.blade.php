<!-- resources/views/pets/show.blade.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detal Zwierzęcia</title>
</head>
<body>
    <h1>Detal Zwierzęcia</h1>
    <p><strong>ID:</strong> {{ $pet['id'] }}</p>
    <p><strong>Nazwa:</strong> {{ $pet['name'] }}</p>
    <p><strong>Status:</strong> {{ $pet['status'] }}</p>
    <p><strong>Zdjęcia:</strong></p>
    <ul>
        @foreach($pet['photoUrls'] as $url)
            <li><img src="{{ $url }}" alt="Pet Image" style="width: 200px;"></li>
        @endforeach
    </ul>
    <a href="{{ route('pets.index') }}">Powrót do listy zwierząt</a>
</body>
</html>