<?php

namespace App\Repositories;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Poney;
use App\Repositories\Interfaces\IClient;

class ClientRepository extends BaseRepository implements IClient
{
    public function __construct()
    {
        parent::__construct(new Client());
    }

    public function create(ClientRequest $ClientRequest): void
    {
        Client::Create($ClientRequest->validated());
    }

    function update(ClientRequest $ClientRequest, $id): void
    {
        $client = $this->getById($id);
        $client->update($ClientRequest->validated());
    }
}
