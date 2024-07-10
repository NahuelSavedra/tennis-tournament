<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Player::class;

    public function definition()
    {
        $types = ['male', 'female'];

        return [
            'name' => $this->faker->name,
            'skill_level' => $this->faker->numberBetween(0, 100),
            'gender' => $this->faker->randomElement($types),
            'strength' => $this->faker->numberBetween(0, 100),
            'speed' => $this->faker->numberBetween(0, 100),
            'reaction_time' => $this->faker->numberBetween(0, 100),
        ];
    }
}
