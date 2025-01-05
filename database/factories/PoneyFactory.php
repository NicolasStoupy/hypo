<?php

namespace Database\Factories;

use App\Models\Poney;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoneyFactory extends Factory
{
    public $model = Poney::class;
    protected $table = 'poneys';
    /**
     * Create the blueprint for your factory
     * @return array
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->firstName(),
            'max_hour_by_day' => $this->faker->numberBetween(1, 8),
            'created_by' => $this->faker->numberBetween(1, 5),  // ID d'utilisateur existant
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
