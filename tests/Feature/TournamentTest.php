<?php

use App\Models\Tournament;
use App\Models\Player;
use App\Services\GameService;
use App\Services\TournamentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('can start a tournament with rounds', function () {
    $tournament = Tournament::factory()->create();

    $players = Player::factory()->count(8)->create();

    $tournamentService = new TournamentService();
    $tournamentService->registerPlayers($tournament, $players->pluck('id')->toArray());
    $tournamentService->start($tournament);

    expect($tournament->rounds)->toHaveCount(1);
    expect($tournament->rounds->first()->games)->toHaveCount(4);
});


it('advances rounds correctly', function () {
    $tournament = Tournament::factory()->create();

    $players = Player::factory()->count(8)->create();

    $tournamentService = new TournamentService();
    $tournamentService->registerPlayers($tournament, $players->pluck('id')->toArray());
    $tournamentService->start($tournament);

    expect($tournament->rounds->first()->games)->toHaveCount(4);

    $tournamentService->advanceRound($tournament);
    $tournament->load('rounds.games');
    expect($tournament->rounds)->toHaveCount(2);

    $tournamentService->advanceRound($tournament);
    $tournament->load('rounds.games');
    expect($tournament->rounds)->toHaveCount(3);

    $tournamentService->advanceRound($tournament);
    $tournament->load('rounds.games');
    expect($tournament->winner_id)->not->toBeNull();
    expect($tournament->rounds)->toHaveCount(3);
});


it('determines the correct winner', function () {
    $tournament = Tournament::factory()->create();

    $player1 = Player::factory()->create(['strength' => 100, 'reaction_time' => 100, 'gender' => 'male']);
    $players = Player::factory()->count(7)->create();
    $players->push($player1);

    $tournamentService = new TournamentService();
    $tournamentService->registerPlayers($tournament, $players->pluck('id')->toArray());
    $tournamentService->start($tournament);

    while ($tournament->rounds->last()->games()->whereNull('winner_id')->exists()) {
        $tournamentService->advanceRound($tournament);
        $tournament->load('rounds.games');
    }

    expect($tournament->winner_id)->toBe($player1->id);
});

it('determines winner based on strength and speed for male players', function () {
    $tournament = Tournament::factory()->create();

    $player1 = Player::factory()->create(['strength' => 90, 'speed' => 80, 'gender' => 'male']);
    $player2 = Player::factory()->create(['strength' => 70, 'speed' => 60, 'gender' => 'male']);

    $tournamentService = new TournamentService();
    $tournamentService->registerPlayers($tournament, [$player1->id, $player2->id]);
    $tournamentService->start($tournament);

    while ($tournament->rounds->last()->games()->whereNull('winner_id')->exists()) {
        $tournamentService->advanceRound($tournament);
        $tournament->load('rounds.games');
    }

    expect($tournament->winner_id)->toBe($player1->id);
});

it('determines winner based on reaction time for female players', function () {
    $tournament = Tournament::factory()->create();

    $player1 = Player::factory()->create(['reaction_time' => 80, 'gender' => 'female']);
    $player2 = Player::factory()->create(['reaction_time' => 70, 'gender' => 'female']);

    $tournamentService = new TournamentService();
    $tournamentService->registerPlayers($tournament, [$player1->id, $player2->id]);
    $tournamentService->start($tournament);

    while ($tournament->rounds->last()->games()->whereNull('winner_id')->exists()) {
        $tournamentService->advanceRound($tournament);
        $tournament->load('rounds.games');
    }

    expect($tournament->winner_id)->toBe($player1->id);
});
