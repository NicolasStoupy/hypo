<?php

namespace App\Repositories;

use App\Http\Requests\PoneyRequest;
use App\Http\Requests\StatusRequest;
use App\Models\Poney;
use App\Models\PoneyActivityKpi;
use App\Models\Status;
use App\Repositories\Interfaces\IPoney;
use App\Repositories\Interfaces\IStatus;

class StatusRepository extends BaseRepository implements IStatus
{

    public function __construct()
    {
        parent::__construct(new Status());
    }

    public function create(StatusRequest $statusRequest): void
    {
        Poney::Create($statusRequest->validated());
    }

    public function update(StatusRequest $statusRequest, $id): void
    {
        $poney = $this->getById($id);
        $poney->update($statusRequest->validated());

    }
}
