<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Config::insert([
            ['key' => 'INVOICE_FORMAT', 'value' => 'PDF', 'type' => 'string'],
            ['key' => 'INVOICE_TAX_RATE', 'value' => '21', 'type' => 'decimal'],
            ['key' => 'INVOICE_NUMBER_PREFIX', 'value' => 'FACT-', 'type' => 'string'],
            ['key' => 'INVOICE_PAYMENT_TERMS', 'value' => '30', 'type' => 'integer'],
            ['key' => 'INVOICE_CURRENCY', 'value' => '€', 'type' => 'string'],
            ['key' => 'INVOICE_LOGO_PATH', 'value' => '/logo_big.png', 'type' => 'string'],
            ['key' => 'INVOICE_ORGANISATION', 'value' => 'Equilibre', 'type' => 'string'],
            ['key' => 'INVOICE_INTERPRISE_ID', 'value' => 'BE085052032', 'type' => 'string'],
            ['key' => 'ADDRESS', 'value' => 'Rue du tisserand 6 5070 Fosses la ville', 'type' => 'string'],
            ['key' => 'INVOICE_BANKNUMBER', 'value' => '052-655-633', 'type' => 'string'],
            ['key' => 'INVOICE_BANK', 'value' => 'BELFIUS', 'type' => 'string'],
            ['key' => 'INVOICE_EURBANKNUMBER', 'value' => 'BE063052-655-633', 'type' => 'string'],
            ['key' => 'BOX_DELAY_HOUR', 'value' => '1', 'type' => 'string'],
        ]);


    }
}
