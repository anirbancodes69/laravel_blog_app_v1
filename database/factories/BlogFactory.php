<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'created_at' => fake()->dateTimeBetween('-2 years', now()),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], now());
            }
        ];
    }
}
