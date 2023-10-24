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
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'id_card_number' => $this->faker->numerify('###########'),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'last_login' => $this->faker->dateTimeBetween($startDate, $endDate),
        ];
    }
}
