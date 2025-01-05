<?php

namespace App\Repositories;

use App\Http\Requests\FactureRequest;
use App\Models\Facture;
use App\Models\Facturier;
use App\Models\Facturier_client;
use App\Models\Poney;
use App\Repositories\Interfaces\IFacture;


class FactureRepository extends BaseRepository implements IFacture
{

    public function __construct()
    {
        parent::__construct(new Facture());
    }

    public function create(FactureRequest $factureRequest): void
    {
        Facture::Create($factureRequest->validated());
    }

    public function update(FactureRequest $factureRequest, $id): void
    {
        $facture = $this->getById($id);
        $facture->update($factureRequest->validated());

    }

    public function getFacturier($year){


        return Facturier::where('year', $year)->get();

    }


    public function getFacturierClient(int $year)
    {
       return Facturier_client::where('year', $year)->get();
    }

    public function getCurrentMonthFacturierClient()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        return Facturier_client::where('year', $currentYear)->where('month', $currentMonth)->get();
    }
}
