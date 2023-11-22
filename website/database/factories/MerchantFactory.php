<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $startDate = '2022-01-01';
        $endDate = '2023-12-31';
        return [
            'name' => $this->faker->company(),
            'email'  => $this->faker->unique()->safeEmail,
            'phone_number' =>  '628' .  $this->faker->randomNumber(9, true),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'id_card_number' => $this->faker->numerify('###########'),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            // 'is_approve' => $this->faker->randomElement(['approve', 'not_approve', null]),
            'is_approve' => $this->faker->randomElement(['approve', 'not_approve']),
            'last_login' => $this->faker->dateTimeBetween($startDate, $endDate),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => $this->faker->numberBetween(2020, 2023),
        ];
    }
}
