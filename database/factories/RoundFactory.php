<?php

namespace Database\Factories;

use App\Models\Round;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Round>
 */
class RoundFactory extends Factory
{
    protected $model = Round::class;

    public function definition()
    {
        return [
            'tournament_id' => Tournament::factory(),
            'round_number' => $this->faker->numberBetween(1, 5),
        ];
    }
}
