<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\PoneyRequest;

    interface IPoney extends IRepository
    {

        /**
         * Crée un nouveau poney à partir des données fournies.
         *
         * @param PoneyRequest $poneyRequest Requête contenant les informations du poney.
         */
        public function create(PoneyRequest $poneyRequest);

        /**
         * Met à jour un poney existant avec les nouvelles données fournies.
         *
         * @param PoneyRequest $poneyRequest Requête contenant les nouvelles informations du poney.
         * @param int|string $id Identifiant du poney à mettre à jour.
         */
        function update(PoneyRequest $poneyRequest, $id);

        /**
         * Récupère les indicateurs de performance clés (KPIs) liés aux poneys.
         */
        function getKpi();

    }
}
