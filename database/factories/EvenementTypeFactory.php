<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EvenementType>
 */
class EvenementTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'nom' => $this->faker->name
        ];
    }
}
