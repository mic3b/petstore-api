<!-- resources/views/pets/edit.blade.php -->
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edytuj Zwierzę</title>
</head>
<body>
    <h1>Edytuj Zwierzę</h1>
    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nazwa Zwierzęcia:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $pet['name']) }}" required><br>

        <label for="category_name">Kategoria:</label>
        <input type="text" name="category[name]" id="category_name" value="{{ old('category.name', $pet['category']['name']) }}" required><br>

        <label for="photoUrls">URL Zdjęcia:</label>
        <input type="text" name="photoUrls[]" value="{{ old('photoUrls[0]', $pet['photoUrls'][0]) }}" required><br>

        <label for="tags">Tagi:</label>
        @foreach($pet['tags'] as $index => $tag)
            <input type="text" name="tags[{{ $index }}][name]" value="{{ old('tags.' . $index . '.name', $tag['name']) }}" required><br>
        @endforeach

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