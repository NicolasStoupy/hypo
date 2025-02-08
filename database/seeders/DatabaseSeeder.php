<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Config;
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

        Config::insert([
            ['key' => 'INVOICE_FORMAT', 'value' => 'PDF', 'type' => 'string'],
            ['key' => 'INVOICE_TAX_RATE', 'value' => '21', 'type' => 'decimal'],
            ['key' => 'INVOICE_NUMBER_PREFIX', 'value' => 'FACT-', 'type' => 'string'],
            ['key' => 'INVOICE_PAYMENT_TERMS', 'value' => '30', 'type' => 'integer'],
            ['key' => 'INVOICE_CURRENCY', 'value' => '€', 'type' => 'string'],
            ['key' => 'INVOICE_LOGO_PATH', 'value' => '/images/logo_50px.png', 'type' => 'string'],
            ['key' => 'INVOICE_ORGANISATION', 'value' => 'Equilibre', 'type' => 'string'],
            ['key' => 'INVOICE_INTERPRISE_ID', 'value' => 'BE085052032', 'type' => 'string'],
            ['key' => 'ADDRESS', 'value' => 'Rue du tisserand 6 5070 Fosses la ville', 'type' => 'string'],
            ['key' => 'INVOICE_BANKNUMBER', 'value' => '052-655-633', 'type' => 'string'],
            ['key' => 'INVOICE_BANK', 'value' => 'BELFIUS', 'type' => 'string'],
            ['key' => 'INVOICE_EURBANKNUMBER', 'value' => 'BE063052-655-633', 'type' => 'string'],
        ]);
    }
}
