<?php

namespace Database\Factories;


use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    public $model = Status::class;
    protected $table = 'status';

    public function definition()
    {
        return [
            ['id' => 'EC', 'description' => 'En Cours'],      // Facture en cours de traitement
            ['id' => 'PA', 'description' => 'Payée'],        // Facture réglée
            ['id' => 'AN', 'description' => 'Annulée'],      // Facture ,evenement annulée
            ['id' => 'IM', 'description' => 'Impayée'],      // Facture non réglée
            ['id' => 'PR', 'description' => 'Prévu'],         // L'événement est planifié.
            ['id' => 'EN', 'description' => 'En cours'],     // L'événement est en train de se dérouler.
            ['id' => 'TE', 'description' => 'Terminé']      // L'événement est terminé.

        ];
    }

    public function getStatus(){
        return ['EC','PA','AN','IM','PR','EN','TE'];
    }
    public function createStatuses(): void
    {
        // Insérer les statuts dans la base de données
        foreach ($this->definition() as $status) {
            Status::create($status);
        }
    }
}
