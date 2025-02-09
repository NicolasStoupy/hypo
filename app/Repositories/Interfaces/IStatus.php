<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\StatusRequest;

    interface IStatus extends IRepository
    {
        /**
         * Crée un nouveau statut à partir des données fournies.
         *
         * @param StatusRequest $statusRequest Requête contenant les informations du statut.
         */
        public function create(StatusRequest $statusRequest);

        /**
         * Met à jour un statut existant avec les nouvelles données fournies.
         *
         * @param StatusRequest $statusRequest Requête contenant les nouvelles informations du statut.
         * @param int|string $id Identifiant du statut à mettre à jour.
         */
        function update(StatusRequest $statusRequest, $id);
    }
}
