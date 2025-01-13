<?php

namespace App\Repositories;

use App\Http\Requests\EvenementPoneyRequest;
use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use App\Models\EvenementType;
use App\Repositories\Interfaces\IEvenement;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvenementRepository extends BaseRepository implements IEvenement
{
    public function __construct()
    {
        parent::__construct(new Evenement());
    }

    public function create(EvenementRequest $EvenementRequest): void
    {
        Evenement::Create($EvenementRequest->validated());
    }

    function update(EvenementRequest $EvenementRequest, $id): void
    {
        $evenement = $this->getById($id);
        $evenement->update($EvenementRequest->validated());
    }

    function getKpi(): array
    {
        // Obtenir la date actuelle et soustraire x semaines
        $startDate = Carbon::now()->subWeeks(300);

        // Récupérer les événements des 10 dernières semaines
        $events = Evenement::where('date_debut', '>=', $startDate)
            ->selectRaw('strftime("%Y-%W", date_debut) as week, count(*) as qtyElement')  // Formatage de la semaine
            ->groupByRaw('strftime("%Y-%W", date_debut)')  // Groupement par semaine
            ->orderByRaw('strftime("%Y-%W", date_debut) ASC')  // Trier par semaine
            ->get();
        return $events->toArray();
    }

    function getEvenementsByDate($date): Collection
    {
        try {
            if (!isset($date)) return $this->getAll();
            // Parse la date et s'assurer qu'elle est valide
            $parsedDate = Carbon::parse($date)->format('Y-m-d');

            // Récupère les événements en filtrant par date (sans l'heure)
            $events = Evenement::whereDate('date_evenement', '=', $parsedDate)
                ->orderBy('date_debut', 'asc')
                ->get();

            return $events;
        } catch (Exception $e) {
            // En cas d'erreur, vous pouvez logguer ou gérer l'exception
            Log::error("Erreur lors de la récupération des événements : " . $e->getMessage());
            return collect();  // Retourne une collection vide en cas d'erreur
        }
    }

    public function addPoney(EvenementPoneyRequest $evenementPoneyRequest,$poneyToReplace = null)
    {
        $evenement = $this->getById($evenementPoneyRequest->evenement_id);
        $distinctPoneys = $evenement->poneys()->pluck('id');

        // Supprimer l'ID du poney à remplacer
        $distinctPoneys = $distinctPoneys->reject(function ($id) use ($poneyToReplace) {
            return $id == $poneyToReplace;
        });

        // Ajouter le nouveau poney
        $distinctPoneys->push($evenementPoneyRequest->poney_id);

        // Synchroniser les poneys avec l'événement
        $evenement->poneys()->sync($distinctPoneys->toArray());


    }

    public function getEvenementsByYear($year)
    {
        return Evenement::whereYear('date_debut', $year)->get();
    }

    function getEvenementTypes()
    {
       return EvenementType::all();
    }
}
