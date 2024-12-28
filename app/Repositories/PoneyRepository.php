<?php

namespace App\Repositories;

use App\Http\Requests\PoneyRequest;
use App\Models\Poney;
use App\Repositories\Interfaces\IPoney;

class PoneyRepository extends BaseRepository implements IPoney
{

    public function __construct()
    {
        parent::__construct(new Poney());
    }

    public function create(PoneyRequest $poneyRequest): void
    {
        Poney::Create($poneyRequest->validated());
    }
    public function update(PoneyRequest $poneyRequest, $id): void
    {
        $poney = $this->getById($id);
        $poney->update($poneyRequest->validated());

    }


}
