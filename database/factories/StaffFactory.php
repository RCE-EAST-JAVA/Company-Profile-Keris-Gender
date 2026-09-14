<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->word(),
            'category' => fake()->randomElement(['Research Assistant', 'Researcher']),
            'expertise' => fake()->word(),
            'description' => fake()->text(),
            'image' => fake()->word(),
            'email' => fake()->safeEmail(),
            'linkedin' => fake()->word(),
            'sort_order' => fake()->randomNumber(),
        ];
    }
}
