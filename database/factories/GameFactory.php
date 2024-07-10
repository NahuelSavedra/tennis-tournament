<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'round_id' => Round::factory(),
            'player1_id' => Player::factory(),
            'player2_id' => Player::factory(),
            'player1_luck' => $this->faker->numberBetween(0, 100),
            'player2_luck' => $this->faker->numberBetween(0, 100),
            'winner_id' => null,
        ];
    }
}
