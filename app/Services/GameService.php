<?php
namespace App\Services;

use App\Models\Game;

class GameService
{
    public function determineWinner(Game $game)
    {
        $player1 = $game->player1->getClass();
        $player2 = $game->player2->getClass();

        $game->player1_luck = $player1->calculateLuck();
        $game->player2_luck = $player2->calculateLuck();

        $player1Score = $player1->calculateScore() + $game->player1_luck;
        $player2Score = $player2->calculateScore() + $game->player2_luck;

        if ($player1Score > $player2Score) {
            $game->winner_id = $game->player1->id;
        } else {
            $game->winner_id = $game->player2->id;
        }

        $game->save();
    }
}
