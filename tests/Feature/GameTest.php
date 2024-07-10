<?php

use App\Models\Player;
use App\Models\Tournament;
use App\Services\GameService;

it('can determine a winner between two players', function () {
    $player1 = Player::factory()->create();
    $player2 = Player::factory()->create();
    $tournament = Tournament::factory()->create();
    $round = $tournament->rounds()->create(['round_number' => 1]);

    $game = $round->games()->create([
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    $gameService = new GameService();
    $gameService->determineWinner($game);

    expect($game->winner_id)->not->toBeNull();
    expect([$player1->id, $player2->id])->toContain($game->winner_id);
});

it('assigns different luck values for each game', function () {
    $player1 = Player::factory()->create([
        'skill_level' => 70,
        'strength' => 50,
        'speed' => 60,
    ]);
    $player2 = Player::factory()->create([
        'skill_level' => 50,
        'strength' => 40,
        'speed' => 45,
    ]);

    $tournament = Tournament::factory()->create();
    $round = $tournament->rounds()->create(['round_number' => 1]);

    $game1 = $round->games()->create([
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    $gameService = new GameService();
    $gameService->determineWinner($game1);

    expect($game1->player1_luck)->not->toBeNull();
    expect($game1->player2_luck)->not->toBeNull();

    $game2 = $round->games()->create([
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    $gameService->determineWinner($game2);

    expect($game2->player1_luck)->not->toBeNull();
    expect($game2->player2_luck)->not->toBeNull();

    expect($game1->player1_luck)->not->toBe($game2->player1_luck);
    expect($game1->player2_luck)->not->toBe($game2->player2_luck);
});

it('it determines winner based on strength and speed for male players', function () {
    $player1 = Player::factory()->create(['gender' => 'male', 'strength' => 70, 'speed' => 60]);
    $player2 = Player::factory()->create(['gender' => 'male', 'strength' => 50, 'speed' => 40]);

    $tournament = Tournament::factory()->create();
    $round = $tournament->rounds()->create(['round_number' => 1]);

    $game = $round->games()->create([
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    $gameService = new GameService();
    $gameService->determineWinner($game);

    expect($game->winner_id)->toBe($player1->id);
});

it('it determines winner based on reaction time for female players', function () {
    $player1 = Player::factory()->create(['gender' => 'female', 'reaction_time' => 30]);
    $player2 = Player::factory()->create(['gender' => 'female', 'reaction_time' => 50]);

    $tournament = Tournament::factory()->create();
    $round = $tournament->rounds()->create(['round_number' => 1]);

    $game = $round->games()->create([
        'player1_id' => $player1->id,
        'player2_id' => $player2->id,
    ]);

    $gameService = new GameService();
    $gameService->determineWinner($game);

    expect($game->winner_id)->toBe($player2->id);
});
