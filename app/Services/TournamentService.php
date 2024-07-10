<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Tournament;

class TournamentService
{
    public function registerPlayers(Tournament $tournament, $players)
    {
        $tournament->players()->attach($players);
    }

    public function start(Tournament $tournament)
    {
        $players = $tournament->players;
        $this->createRound($tournament, 1, $players);
    }

    public function advanceRound(Tournament $tournament)
    {
        $currentRoundNumber = $tournament->rounds()->max('round_number');
        $currentRound = $tournament->rounds()->where('round_number', $currentRoundNumber)->first();

        $winners = collect();
        foreach ($currentRound->games as $game) {
            $gameService = new GameService();
            $gameService->determineWinner($game);
            $winners->push(Player::find($game->winner_id));
        }

        if ($winners->count() > 1) {
            $this->createRound($tournament, $currentRoundNumber + 1, $winners);
        } else {
            // Winner of the tournament
            $tournament->winner_id = $winners->first()->id;
            $tournament->save();
        }
    }

    protected function createRound(Tournament $tournament, int $roundNumber, $players)
    {
        $round = $tournament->rounds()->create([
            'round_number' => $roundNumber,
        ]);

        while ($players->count() > 1) {
            $pair = $players->splice(0, 2);
            $round->games()->create([
                'player1_id' => $pair[0]->id,
                'player2_id' => $pair[1]->id,
            ]);
        }
    }
}
