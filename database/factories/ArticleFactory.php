<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'thumbnail' => fake()->word(),
            'excerpt' => fake()->text(),
            'body' => fake()->text(),
            'author' => fake()->word(),
            'user_id' => User::factory(),
            'category' => fake()->word(),
            'status' => fake()->randomElement(['draft', 'published']),
            'tags' => fake()->word(),
            'published_at' => fake()->dateTime(),
            'is_pinned' => fake()->boolean(),
        ];
    }
}
