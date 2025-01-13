<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\ClientRequest;
    use App\Http\Requests\EvenementPoneyRequest;
    use App\Http\Requests\EvenementRequest;

    interface IEvenement extends IRepository
    {

        public function create(EvenementRequest $EvenementRequest);

        function update(EvenementRequest $EvenementRequest, $id);

        function getKpi():array;

        function getEvenementsByDate($date);
        function getEvenementsByYear($year);

        function addPoney(EvenementPoneyRequest $evenementPoneyRequest,$poneyToReplace = null);

        function getEvenementTypes();

    }
}
