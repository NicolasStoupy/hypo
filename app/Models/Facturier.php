<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facturier extends Model
{
    protected $table = 'facturier';

    public $timestamps = false;
    // Empêcher l'insertion et la mise à jour
    protected $guarded = [];


    public function facturier_clients()
    {
        return Facturier_client::where('year', $this->year)
            ->where('month', $this->month)
            ->get();
    }
    public function hasCurrentYear()
    {
        return $this->year === Carbon::now()->year;
    }

    public function hasCurrentMonth(){
        return $this->month === Carbon::now()->month;

    }

    public function hasCurrentYearMonth(){
        return $this->hasCurrentYear() && $this->hasCurrentMonth();
    }


    public function getYearMonth() {
        // Récupérer la locale depuis le fichier .env
        $locale = env('APP_LOCALE', 'en');

        // Définir la locale de Carbon
        Carbon::setLocale($locale);

        // Créer une instance Carbon avec l'année et le mois
        $date = Carbon::createFromFormat('Y-m', $this->year . '-' . $this->month);

        // Retourner l'année et le mois en littéral dans la langue définie
        return $this->year . ' - ' . $date->translatedFormat('F');  // 'F' donne le mois en entier (ex: janvier)
    }
}
