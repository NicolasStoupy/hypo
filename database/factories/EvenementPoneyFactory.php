<?php

namespace Database\Factories;

use App\Models\Evenement;
use App\Models\EvenementPoney;
use App\Models\Poney;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvenementPoneyFactory extends Factory
{

    public $model = EvenementPoney::class;
    protected $table = 'evenement_poneys';
    /**
     * Create the blueprint for your factory
     * @return array
     */
    public function definition(): array
    {
        return [
            'evenement_id' => $this->faker->numberBetween(1, 10),  // ID d'événement existant
            'poney_id' => $this->faker->numberBetween(1, 10),      // ID de poney existant
            'created_by' => $this->faker->numberBetween(1, 5),      // ID d'utilisateur existant
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
