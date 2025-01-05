<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\FactureRequest;

    interface IFacture extends IRepository
    {
        public function create(FactureRequest $factureRequest);

        function update(FactureRequest $factureRequest, $id);
        function getFacturier(int $year);

        public function getFacturierClient(int $year);
        public function getCurrentMonthFacturierClient();
    }
}
