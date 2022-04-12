<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'group_id' => $this->faker->numberBetween(1,10),
            'cnpj' => $this->faker->randomNumber(7, true) . $this->faker->randomNumber(7, true),
            'name' => $this->faker->name(),
            'foundation_date' => $this->faker->date(),
        ];
    }
}
