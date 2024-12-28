<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\EvenementPoney;
use App\Models\Facture;
use App\Models\Poney;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();


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

        // Seed evenements
        Evenement::factory(10)->create([
            'created_by' => User::inRandomOrder()->first()->id,
            'facture_id' => Facture::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
        ]);
        $evenements = Evenement::inRandomOrder()->take(10)->get();
        $poneys = Poney::inRandomOrder()->take(10)->get();
        $users = User::inRandomOrder()->take(10)->get();

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
                        'created_by' => $users->random()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

// Ensuite, vous pouvez insérer les enregistrements dans la table
        EvenementPoney::insert($evenementsPoneys->toArray());
    }
}
