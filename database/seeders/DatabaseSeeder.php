<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\EvenementPoney;
use App\Models\EvenementType;
use App\Models\Facture;
use App\Models\Poney;
use App\Models\Status;
use App\Models\User;
use Database\Factories\StatusFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        (new \Database\Factories\StatusFactory)->createStatuses();
        // Seed poneys
        Poney::factory(20)->create([
            'created_by' => User::inRandomOrder()->first()->id,
        ]);

        // Seed clients
        Client::factory(15)->create([
            'created_by' => User::inRandomOrder()->first()->id,
        ]);

        // Seed factures
        Facture::factory(10)->create();


        // seed evenement_type
        $evenement_types = ['Association','Poney Club','Stage'];
        foreach ($evenement_types as $type) {
                EvenementType::create(['nom' => $type]);
            }

        // Seed evenements
        $userIds = User::pluck('id')->toArray();
        $factureIds = Facture::pluck('id')->toArray();
        $clientIds = Client::pluck('id')->toArray();

        for ($i = 1; $i < 10; $i++) {

            Evenement::factory(10)->create([
                'created_by' => $userIds[array_rand($userIds)],
                'facture_id' => $factureIds[array_rand($factureIds)],
                'client_id' => $clientIds[array_rand($clientIds)],
            ]);

        }

        $evenements = Evenement::inRandomOrder()->take(10)->get();
        $poneys = Poney::inRandomOrder()->take(10)->get();



// Créer les 10 enregistrements de manière unique
        $evenementsPoneys = collect();

        foreach ($evenements as $evenement) {
            foreach ($poneys as $poney) {
                if (!$evenementsPoneys->contains(function ($item) use ($evenement, $poney) {
                    return $item['evenement_id'] == $evenement->id && $item['poney_id'] == $poney->id;
                })) {
                    $evenementsPoneys->push([
                        'evenement_id' => $evenement->id,
                        'poney_id' => $poney->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }


        EvenementPoney::insert($evenementsPoneys->toArray());
    }
}
