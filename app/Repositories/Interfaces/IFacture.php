<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\FactureCavalierRequest;
    use App\Http\Requests\FactureEvenementRequest;
    use App\Http\Requests\FactureRequest;
    use App\Models\Cavalier;
    use App\Models\Evenement;
    use PhpParser\Node\Expr\Cast\Double;
    use PhpParser\Node\Scalar\Float_;

    interface IFacture extends IRepository
    {
        public function create(FactureRequest $factureRequest);

        function update(FactureRequest $factureRequest, $id);
        function getFacturier(int $year);

        public function getFacturierClient(int $year);
        public function getCurrentMonthFacturierClient();
        public function creationFactureCavalier(FactureCavalierRequest $request);
        public function creationFactureEvnement($evenement_id);
        public function delete_by_cavalier($cavalier_id);
    }
}
