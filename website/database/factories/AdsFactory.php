<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ads>
 */
class AdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_id' => $this->faker->numberBetween(1, 100),
            'category_id' => $this->faker->numberBetween(1, 4),
            'name' => $this->faker->sentence(5),
            'description' => $this->faker->realText(),
            'notes'  => $this->faker->realText(),
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'count_order' => $this->faker->numberBetween(1, 50),
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'count_view' => $this->faker->numberBetween(10, 500),
            // 'is_approve' => $this->faker->randomElement(['approve', 'not_approve', null]),
            'is_approve' => $this->faker->randomElement(['approve', 'not_approve']),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => 2023,
        ];
    }
}
