<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Torneo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center mb-4">Simulación de Torneo</h1>
    <form action="/tournament/simulate" method="POST" class="bg-white shadow rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="num_players" class="block text-gray-700 text-sm font-bold mb-2">Número de Jugadores:</label>
            <input type="number" id="num_players" name="num_players" class="form-control rounded-md border border-gray-300 py-2 px-3 text-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            @error('num_players')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simular</button>
    </form>
</div>
</body>
</html>
