<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\EvenementPoney;
use App\Models\Facture;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
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
        $status = new  StatusFactory();

        $dateDebut = $this->faker->dateTimeBetween('-365 days', '+50 day'); // Génère une date aléatoire dans le passé (entre 1 et 10 jours avant aujourd'hui)
        $dateFin = (clone $dateDebut)->modify('+1 hour'); // Ajoute 1 jour et 1 heure à `date_debut`
        $date_evenement = Carbon::parse($dateDebut)->format('Y-m-d');
        return [
            'prix' => $this->faker->randomFloat(2, 50, 1000),  // Prix entre 50 et 1000
            'nombre_participant' => $this->faker->numberBetween(1, 5),
            'facture_id' => $this->faker->numberBetween(1, 5),  // ID de facture existant
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'nom'=>$this->faker->name,
            'date_evenement'=>$date_evenement,
            'client_id' => $this->faker->numberBetween(1, 10),  // ID de client existant
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'status_id' => $this->faker->randomElement( $status->getStatus())
        ];
    }
}
