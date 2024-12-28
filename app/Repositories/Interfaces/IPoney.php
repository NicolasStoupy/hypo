<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\PoneyRequest;

interface IPoney extends IRepository
{


    public function create(PoneyRequest $poneyRequest);

    function update(PoneyRequest $poneyRequest, $id);
    function getKpi();

}
