<?php

namespace Database\Factories;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{

    public $model = Facture::class;
    protected $table = 'factures';

    /**
     * Create the blueprint for your factory
     * @return array
     */
    public function definition(): array
    {
        $status = new StatusFactory();

        return [

            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'status_id' => $this->faker->randomElement( $status->getStatus())
        ];
    }
}
