<!-- resources/views/pets/create.blade.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Zwierzę</title>
</head>
<body>
    <h1>Dodaj Nowe Zwierzę</h1>
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <label for="name">Nazwa Zwierzęcia:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="photoUrls">URL Zdjęcia:</label>
        <input type="text" name="photoUrls[]" required><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="available">Dostępne</option>
            <option value="pending">W trakcie</option>
            <option value="sold">Sprzedane</option>
        </select><br>

        <button type="submit">Dodaj</button>
    </form>
    <a href="{{ route('pets.index') }}">Powrót do listy zwierząt</a>
</body>
</html>