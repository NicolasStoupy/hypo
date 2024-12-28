<?php

namespace App\Repositories;

use App\Http\Requests\FactureRequest;
use App\Models\Facture;
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


}
