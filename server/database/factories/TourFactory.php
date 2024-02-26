<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TourFactory extends Factory
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
            'description' => fake()->text(200),
            'location' => fake()->address(),
            'includes' => [
                fake()->word(),
                fake()->word(),
                fake()->word(),
            ],
            'excludes' => [
                fake()->word(),
                fake()->word(),
                fake()->word(),
            ],
            'duration' => fake()->word(),
            'price' => fake()->numberBetween(100, 5000),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
