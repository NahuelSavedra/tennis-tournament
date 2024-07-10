<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        return view('tournament.index');
    }

    public function simulate(Request $request)
    {
        $request->validate([
            'num_players' => ['required', 'integer', 'in:[2, 4, 8, 16, 32, 64, 128]'],
        ]);

        $numPlayers = (int) $request->input('num_players');

        $tournament = Tournament::factory()->create();
        $players = Player::factory()->count($numPlayers)->create();

        $tournamentService = new TournamentService();
        $tournamentService->registerPlayers($tournament, $players->pluck('id')->toArray());
        $tournamentService->start($tournament);

        // Simulate rounds until a winner is determined
        while ($tournament->winner_id === null) {
            $tournamentService->advanceRound($tournament);
        }

        $winner = $players->where('id', $tournament->winner_id)->first();
        $tournament->load('rounds.games');

        return view('tournament.results',['tournament' => $tournament, 'winner' => $winner]);
    }
}
