<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\ClientRequest;
    use App\Http\Requests\EvenementPoneyRequest;
    use App\Http\Requests\EvenementRequest;
    use App\Models\Evenement;

    interface IEvenement extends IRepository
    {
        /**
         * Crée un nouvel événement à partir des données fournies.
         *
         * @param EvenementRequest $EvenementRequest
         * @return Evenement Retourne l'événement créé.
         */
        public function create(EvenementRequest $EvenementRequest): Evenement;

        /**
         * Met à jour un événement existant avec les nouvelles données fournies.
         *
         * @param EvenementRequest $EvenementRequest
         * @param int|string $id Identifiant de l'événement à mettre à jour.
         * @return mixed Retourne l'événement mis à jour ou une réponse appropriée.
         */
        function update(EvenementRequest $EvenementRequest, $id);

        /**
         * Récupère les indicateurs de performance clés (KPIs) liés aux événements.
         *
         * @return array Retourne un tableau contenant les KPIs.
         */
        function getKpi(): array;

        /**
         * Récupère la liste des événements pour une date donnée.
         *
         * @param string $date Date au format YYYY-MM-DD.
         */
        function getEvenementsByDate($date);

        /**
         * Récupère la liste des événements pour une année donnée.
         *
         * @param int $year Année concernée.
         */
        function getEvenementsByYear($year);

        /**
         * Ajoute un poney à un événement.
         *
         * @param EvenementPoneyRequest $evenementPoneyRequest Requête contenant les détails de l'affectation.
         * @param int|string|null $poneyToReplace Identifiant du poney à remplacer (optionnel).
         */
        function addPoney(EvenementPoneyRequest $evenementPoneyRequest, $poneyToReplace = null);

        /**
         * Récupère la liste des types d'événements disponibles.
         *
         */
        function getEvenementTypes();

        /**
         * Ajoute plusieurs cavaliers à un événement.
         *
         * @param array $cavaliers Liste des cavaliers à ajouter.
         * @param int|string $evenement_id Identifiant de l'événement.
         */
        function addCavaliers(array $cavaliers, $evenement_id);


        /**
         * Met à jour les informations des cavaliers d'un événement.
         *
         * @param array $cavaliers Liste des cavaliers mis à jour.
         */
        public function updateCavaliers(array $cavaliers);

    }
}
