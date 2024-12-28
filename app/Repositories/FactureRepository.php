<?php

namespace App\Repositories;

use App\Http\Requests\FactureRequest;
use App\Models\Poney;
use App\Repositories\Interfaces\IFacture;


class FactureRepository extends BaseRepository implements IFacture
{

    public function __construct()
    {
        parent::__construct(new Poney());
    }

    public function create(FactureRequest $factureRequest): void
    {
        Poney::Create($factureRequest->validated());
    }

    public function update(FactureRequest $factureRequest, $id): void
    {
        $poney = $this->getById($id);
        $poney->update($factureRequest->validated());

    }


}
