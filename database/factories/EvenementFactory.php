<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\EvenementPoney;
use App\Models\Facture;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvenementFactory extends Factory
{
    public $model = Evenement::class;
    protected $table = 'evenements';
    /**
     * Create the blueprint for your factory
     * @return array
     */
    public function definition(): array
    {
        return [
            'prix' => $this->faker->randomFloat(2, 50, 1000),  // Prix entre 50 et 1000
            'nombre_participant' => $this->faker->numberBetween(1, 100),
            'facture_id' => $this->faker->numberBetween(1, 5),  // ID de facture existant
            'date_debut' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'date_fin' => $this->faker->dateTimeBetween('now', '+1 month'),
            'client_id' => $this->faker->numberBetween(1, 10),  // ID de client existant
            'created_by' => $this->faker->numberBetween(1, 5),   // ID d'utilisateur existant
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
