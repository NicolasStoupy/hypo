<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public $model = Client::class;
    protected $table = 'clients';
    /**
     * Create the blueprint for your factory
     * @return array
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'created_by' => $this->faker->numberBetween(1, 5),  // ID d'utilisateur existant
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
