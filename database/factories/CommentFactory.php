<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_id' => null,
            'comment' => fake()->sentence(),
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-2 years', now()),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], now());
            }
        ];
    }

    public function good()
    {
        return $this->state(function () {
            return ['rating' => fake()->numberBetween(4, 5)];
        });
    }

    public function avg()
    {
        return $this->state(function () {
            return ['rating' => fake()->numberBetween(2, 3)];
        });
    }

    public function bad()
    {
        return $this->state(function () {
            return ['rating' => fake()->numberBetween(1, 2)];
        });
    }
}
