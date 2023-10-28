<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'ads_id'  => $this->faker->numberBetween(1, 100),
            'total_transaction' => $this->faker->numberBetween(100000, 1000000),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => '2023',
        ];
    }
}
