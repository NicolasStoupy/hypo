<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\StatusRequest;

    interface IStatus extends IRepository
    {

        public function create(StatusRequest $statusRequest);

        function update(StatusRequest $statusRequest, $id);
    }
}
