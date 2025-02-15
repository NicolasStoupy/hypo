<?php

namespace App\Repositories;


use App\Models\WeeklyOpeningHour;
use App\Repositories\Interfaces\IFacture;
use App\Repositories\Interfaces\IOpenHours;
use Illuminate\Support\Carbon;

class OpenHoursRepository extends BaseRepository implements IOpenHours
{
    public function __construct()
    {
        parent::__construct(new WeeklyOpeningHour());
    }
    function IsOpenDay($date): array
    {
        // Extraire l'année, la semaine et le jour sous forme d'entier avec Carbon
        $carbonDate = Carbon::parse($date); // Parse la date avec Carbon

        $year = $carbonDate->year; // ISO week year
        $weekNumber = $carbonDate->week; // ISO week number
        $dayOfWeek = $carbonDate->dayOfWeek(); // 0 = Lundi, 6 = Dimanche


        // Rechercher dans la base de données
        $day = $this->model->where('year', $year)
            ->where('week_number', $weekNumber)
            ->where('day', $dayOfWeek)
            ->first();

        // Si aucune donnée n'est trouvée, considérer comme fermé
        if (!$day) {
            return [
                'is_open' => false, // Le jour est fermé
                'week' => $weekNumber,
                'day'=> $dayOfWeek,
                'year' => $year
            ];
        }

        // Vérification du statut d'ouverture
        return [
            'is_open' => $day->is_closed != 1, // Si is_closed est 1, le jour est fermé, sinon ouvert
            'week' => $weekNumber,
            'day'=> $dayOfWeek,
            'year' => $year
        ];
    }

}
