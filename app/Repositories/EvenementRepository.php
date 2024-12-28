<?php

namespace App\Repositories;

use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use App\Repositories\Interfaces\IEvenement;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
}
