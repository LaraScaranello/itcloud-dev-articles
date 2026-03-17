<?php

namespace Database\Factories;

use App\Models\Developer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Developer>
 */
class DeveloperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'seniority' => fake()->randomElement(['jr', 'pl', 'sr']),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
