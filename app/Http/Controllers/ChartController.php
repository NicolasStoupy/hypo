<?php

namespace App\Http\Controllers {

    use App\Repositories\Interfaces\IApplicationContext;
    use Illuminate\Http\JsonResponse;

    class ChartController extends Controller
    {
        public function __construct(protected IApplicationContext $repos)
        {

        }


        public function get_event_chart(): JsonResponse
        {
            return response()->json($this->repos->evenement()->getKpi());

        }

        public function get_poney_chart(): JsonResponse
        {
            return response()->json($this->repos->poney()->getKpi());
        }
    }
}
