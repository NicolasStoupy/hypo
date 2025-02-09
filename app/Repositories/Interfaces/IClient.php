<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\ClientRequest;

    interface IClient extends IRepository
    {
        /**
         * Crée un nouveau client à partir des données fournies.
         *
         * @param ClientRequest $clientRequest Requête contenant les informations du client.
         * @return mixed Retourne l'objet créé ou une réponse appropriée.
         */
        public function create(ClientRequest $ClientRequest);
        /**
         * Met à jour un client existant avec les nouvelles données fournies.
         *
         * @param ClientRequest $clientRequest Requête contenant les nouvelles informations du client.
         * @param int|string $id Identifiant du client à mettre à jour.
         * @return mixed Retourne l'objet mis à jour ou une réponse appropriée.
         */
        function update(ClientRequest $ClientRequest, $id);

    }
}
