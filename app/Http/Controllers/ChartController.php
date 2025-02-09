<?php

namespace App\Http\Controllers {

    use App\Repositories\Interfaces\IApplicationContext;
    use Illuminate\Http\JsonResponse;

    class ChartController extends Controller
    {
        public function __construct(protected IApplicationContext $repos)
        {

        }

        /**
         * Récupère et retourne les indicateurs KPI des événements sous forme de réponse JSON.
         *
         * @return JsonResponse Réponse JSON contenant les KPI des événements.
         */
        public function get_event_chart(): JsonResponse
        {
            return response()->json($this->repos->evenement()->getKpi());

        }
        /**
         * Récupère et retourne les indicateurs KPI des poneys sous forme de réponse JSON.
         *
         * @return JsonResponse Réponse JSON contenant les KPI des poneys.
         */
        public function get_poney_chart(): JsonResponse
        {
            return response()->json($this->repos->poney()->getKpi());
        }
    }
}
