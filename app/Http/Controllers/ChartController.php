<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IApplicationContext;
use Illuminate\Http\JsonResponse;

class ChartController extends Controller
{
    public function __construct(protected IApplicationContext $repos)
    {

    }

    public function getEventChart(): JsonResponse
    {
        return response()->json($this->repos->evenement()->getKpi());

    }

    public function getPoneyChart(): JsonResponse
    {
        return response()->json($this->repos->poney()->getKpi());
    }
}
