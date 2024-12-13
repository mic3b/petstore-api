<!-- resources/views/pets/edit.blade.php -->
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edytuj Zwierzę</title>
</head>
<body>
    <h1>Edytuj Zwierzę</h1>
    <form action="{{ route('pets.update',$pet['id']) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="name">Nazwa Zwierzęcia:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $pet['name']) }}" required><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="available" {{ $pet['status'] == 'available' ? 'selected' : '' }}>Dostępne</option>
            <option value="pending" {{ $pet['status'] == 'pending' ? 'selected' : '' }}>W trakcie</option>
            <option value="sold" {{ $pet['status'] == 'sold' ? 'selected' : '' }}>Sprzedane</option>
        </select><br>

        <button type="submit">Zaktualizuj</button>
    </form>
    <a href="{{ route('pets.index') }}">Powrót do listy zwierząt</a>
</body>
</html>