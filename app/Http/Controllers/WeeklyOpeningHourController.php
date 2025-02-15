<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultHourRequest;
use App\Http\Requests\StoreWeeklyOpeningHoursRequest;
use App\Models\WeeklyOpeningHour;
use Illuminate\Http\Request;

class WeeklyOpeningHourController extends Controller
{
    /**
     * Affiche la liste des horaires d'ouverture pour une semaine spécifique.
     *
     * Cette méthode récupère les horaires d'ouverture pour la semaine et l'année
     * spécifiées dans la requête. Si aucun paramètre n'est fourni, elle utilise
     * la semaine et l'année en cours. Elle ajuste également l'année si la semaine
     * est en dehors de la plage valide (1-52).
     *
     * @param Request $request Requête HTTP contenant éventuellement les paramètres 'week' et 'year'.
     *
     */
    public function index(Request $request)
    {
        $currentWeek = $request->get('week', now()->weekOfYear);
        $currentYear = $request->get('year', now()->year);

        // Ajuster l'année si nécessaire
        if ($currentWeek < 1) {
            $currentWeek = 52;
            $currentYear--;
        } elseif ($currentWeek > 52) {
            $currentWeek = 1;
            $currentYear++;
        }

        // Vérifier si la semaine est passée
        $isPastWeek = ($currentYear < now()->year) || ($currentYear == now()->year && $currentWeek < now()->weekOfYear);

        // Récupérer les horaires d'ouverture, en groupant par jour
        $openingHours = WeeklyOpeningHour::where('week_number', $currentWeek)
            ->where('year', $currentYear)
            ->get();


        return view('weekly_opening_hours.index', compact('openingHours', 'currentWeek', 'currentYear', 'isPastWeek'));
    }

    /**
     * Enregistre ou met à jour les horaires d'ouverture pour une semaine donnée.
     *
     * Cette méthode parcourt les jours de la semaine envoyés dans la requête
     * et met à jour ou crée les horaires d'ouverture correspondants dans la base de données.
     *
     * @param StoreWeeklyOpeningHoursRequest $request Requête validée contenant les horaires d'ouverture pour chaque jour.
     *

     */
    public function store(StoreWeeklyOpeningHoursRequest $request)
    {

        foreach ($request->hours as $day => $data) {
            WeeklyOpeningHour::updateOrCreate(
                [
                    'week_number' => $request->week_number,
                    'year' => $request->year,
                    'day' => $day,
                ],
                [
                    'open_time' => $data['open_time'] ?? null,
                    'close_time' => $data['close_time'] ?? null,
                    'is_closed' => isset($data['is_closed']),
                ]
            );
        }

        return redirect()->route('weekly_hours.index', ['week' => $request->week_number, 'year' => $request->year])
            ->with('success', 'Horaires mis à jour');
    }

    /**
     * Applique les heures d'ouverture par défaut à chaque jour de la semaine spécifiée.
     *
     * Cette méthode parcourt chaque jour de la semaine et met à jour les heures d'ouverture et de fermeture,
     * sauf si le jour est déjà marqué comme fermé (`is_closed`).
     *
     * @param DefaultHourRequest $request Requête validée contenant les heures par défaut et la semaine concernée.
     *
     */
    public function applyDefaultHours(DefaultHourRequest $request)
    {
        $defaultOpenTime = $request->input('default_open_time');
        $defaultCloseTime = $request->input('default_close_time');
        $currentWeek = $request->input('week_number');
        $currentYear = $request->input('year');

        // Appliquer les heures par défaut à chaque jour de la semaine (index entier)
        for ($day = 0; $day < 7; $day++) {
            $openingHour = WeeklyOpeningHour::where('week_number', $currentWeek)
                ->where('year', $currentYear)
                ->where('day', $day)
                ->first();

            // Si l'heure d'ouverture et de fermeture n'ont pas été définies et que le jour n'est pas fermé
            if (!$openingHour || !$openingHour->is_closed) {
                if (!$openingHour) {
                    $openingHour = new WeeklyOpeningHour([
                        'week_number' => $currentWeek,
                        'year' => $currentYear,
                        'day' => $day,
                    ]);
                }
                $openingHour->open_time = $defaultOpenTime;
                $openingHour->close_time = $defaultCloseTime;
                $openingHour->is_closed = false;
                $openingHour->save();
            }
        }

        return redirect()->route('weekly_hours.index', ['week' => $currentWeek, 'year' => $currentYear])
            ->with('success', 'Heures appliquées à toute la semaine.');
    }
}
