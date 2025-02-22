<?php

namespace App\Models;

use App\Helpers\ConfigHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Boxs extends Model
{
    protected $fillable = [
        'last_cleaning'
    ];

    public function needCleaning(){


        $last_cleanning = Carbon::parse($this->last_cleaning);
        $limit_date = $last_cleanning->addHours((int) ConfigHelper::get('BOX_DELAY_HOUR')); // Ajoute l'intervalle entre néttoyage

        return  $limit_date < now();
    }


    public function remainingTime()
    {
        $last_cleaning = Carbon::parse($this->last_cleaning);
        $limit_date = $last_cleaning->addHours((int) ConfigHelper::get('BOX_DELAY_HOUR'));

        if (now()->greaterThan($limit_date)) {
            return 'Dépassé de :' . now()->diff($limit_date, true); // Affiche un "-" pour indiquer le dépassement
        }

        return 'Néttoyage dans :' . now()->diff($limit_date, true);
    }
    public function endTime()
    {
        $last_cleaning = Carbon::parse($this->last_cleaning);
        $limit_date = $last_cleaning->addHours((int) ConfigHelper::get('BOX_DELAY_HOUR'));

        return $limit_date;
    }
    public function Poneys()
    {
        return $this->hasMany(Poney::class,'box_id');
    }
    public function GetAvailablePeriod(): array
    {
        $availablePeriods = [];
        $poneysInBox = $this->Poneys; // Récupérer tous les poneys dans le box

        foreach ($poneysInBox as $poney) {
            // Récupérer les périodes disponibles pour chaque poney dans ce box
            $availablePeriodsData = View_availaibility::where('box_id', $this->id)
                ->where('poney_id', $poney->id)  // Si la disponibilité est liée à un poney spécifique
                ->get();

            foreach ($availablePeriodsData as $period) {
                // Vérifier si cette période est déjà ajoutée aux périodes disponibles pour ce box
                $availablePeriods[] = [
                    'poney_id' => $poney->id,
                    'start' => Carbon::parse($period->debut),
                    'end' => Carbon::parse($period->fin),
                ];
            }
        }


        return $availablePeriods;

    }
}
