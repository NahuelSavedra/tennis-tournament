 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Torneo: {{ $tournament->name }}</h1>

    @foreach ($tournament->rounds as $round)
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold mb-4">Ronda {{ $loop->iteration }}</h2>

            @foreach ($round->games as $game)
                <div class="mb-4">
                    <h3 class="text-xl font-bold mb-2">Juego {{ $loop->iteration }}</h3>
                    <p>Jugadores:</p>
                    <ul class="list-disc ml-5">
                            <li>{{ $game->player1->name }}</li>
                            <li>{{ $game->player2->name }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    @endforeach

        <div>
            <h2>Ganador: {{ $winner->name }}</h2>
            <ul>
                <li>Nivel de Habilidad: {{ $winner->skill_level }}</li>
                <li>Género: {{ $winner->gender }}</li>
                <li>Fuerza: {{ $winner->strength }}</li>
                <li>Velocidad: {{ $winner->speed }}</li>
                <li>Tiempo de Reacción: {{ $winner->reaction_time }}</li>
            </ul>
        </div>
</div>
</body>
</html>
