<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Round;
use App\Models\Tournament;
use App\Services\GameService;


it('a round can have multiple games', function () {
    $round = Round::factory()->create();

    $game1 = Game::factory()->create(['round_id' => $round->id]);
    $game2 = Game::factory()->create(['round_id' => $round->id]);

    expect($round->games)->toHaveCount(2);
});

it('a round belongs to a tournament', function () {
    $tournament = Tournament::factory()->create();
    $round = Round::factory()->create(['tournament_id' => $tournament->id]);

    expect($round->tournament->id)->toBe($tournament->id);
});

it('games in a round have players', function () {
    $round = Round::factory()->create();
    $player1 = Player::factory()->create();
    $player2 = Player::factory()->create();

    $game = Game::factory()->create([
        'round_id' => $round->id,
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    expect($game->player1->id)->toBe($player1->id);
    expect($game->player2->id)->toBe($player2->id);
});

it('a tournament progresses through multiple rounds', function () {
    $tournament = Tournament::factory()->create();

    $round1 = Round::factory()->create(['tournament_id' => $tournament->id, 'round_number' => 1]);
    $round2 = Round::factory()->create(['tournament_id' => $tournament->id, 'round_number' => 2]);

    $player1 = Player::factory()->create();
    $player2 = Player::factory()->create();
    $player3 = Player::factory()->create();
    $player4 = Player::factory()->create();

    // Round 1 games
    $game1 = Game::factory()->create(['round_id' => $round1->id, 'player1_id' => $player1->id, 'player2_id' => $player2->id]);
    $game2 = Game::factory()->create(['round_id' => $round1->id, 'player1_id' => $player3->id, 'player2_id' => $player4->id]);

    $gameService = new GameService();
    $gameService->determineWinner($game1);
    $gameService->determineWinner($game2);

    // Winners of round 1 move to round 2
    $game3 = Game::factory()->create([
        'round_id' => $round2->id,
        'player1_id' => $game1->winner_id,
        'player2_id' => $game2->winner_id,
    ]);

    $gameService->determineWinner($game3);

    expect($game3->winner_id)->not->toBeNull();
    expect([$game1->winner_id, $game2->winner_id])->toContain($game3->winner_id);
});
