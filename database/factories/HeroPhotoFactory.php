<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HeroPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'image' => fake()->word(),
            'caption' => fake()->word(),
            'order' => fake()->randomDigitNotNull(),
            'is_active' => fake()->boolean(),
        ];
    }
}
