<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'category' => fake()->word(),
            'status' => fake()->word(),
            'image' => fake()->word(),
            'author' => fake()->word(),
            'user_id' => User::factory(),
            'date' => fake()->word(),
            'published_at' => fake()->date(),
            'is_pinned' => fake()->boolean(),
        ];
    }
}
