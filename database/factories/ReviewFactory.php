<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'book_id' => null,
            'review' => fake()->paragraph,
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => $createdAt,
            'updated_at' => Carbon::instance($createdAt)->addDays(rand(1, 2)),
        ];
    }

    public function good(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(4, 5), // Good rating range
            ];
        });
    }

    public function average(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => 3, // Fixed average rating
            ];
        });
    }

    public function bad(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(1, 2), // Bad rating range
            ];
        });
    }
}
