<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\ClientRequest;

    interface IClient extends IRepository
    {

        public function create(ClientRequest $ClientRequest);

        function update(ClientRequest $ClientRequest, $id);

    }
}
