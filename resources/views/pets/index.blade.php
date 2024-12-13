<!-- resources/views/pets/index.blade.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Zwierząt</title>
</head>
<body>
    <h1>Lista Zwierząt</h1>
    <a href="{{ route('pets.create') }}">Dodaj Nowe Zwierzę</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pets as $pet)
            <tr>
                <td>{{ $pet['id'] }}</td>
                <td>{{ $pet['name'] ?? 'N/A' }}</td> 
                <td>{{ $pet['status'] }}</td>
                <td>
                    <a href="{{ route('pets.show', $pet['id']) }}">Pokaż</a> |
                    <a href="{{ route('pets.edit', $pet['id']) }}">Edytuj</a> |
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>