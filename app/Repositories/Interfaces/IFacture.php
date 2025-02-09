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
        /**
         * Crée une nouvelle facture à partir des données fournies.
         *
         * @param FactureRequest $factureRequest Requête contenant les informations de la facture.
         */
        public function create(FactureRequest $factureRequest);

        /**
         * Met à jour une facture existante avec les nouvelles données fournies.
         *
         * @param FactureRequest $factureRequest Requête contenant les nouvelles informations de la facture.
         * @param int|string $id Identifiant de la facture à mettre à jour.
         */
        function update(FactureRequest $factureRequest, $id);

        /**
         * Récupère le facturier pour une année donnée.
         *
         * @param int $year Année concernée.
         */
        function getFacturier(int $year);

        /**
         * Récupère le facturier client pour une année donnée.
         *
         * @param int $year Année concernée.
         */
        public function getFacturierClient(int $year);

        /**
         * Récupère le facturier client du mois en cours.
         */
        public function getCurrentMonthFacturierClient();

        /**
         * Crée une facture pour un cavalier.
         *
         * @param FactureCavalierRequest $request Requête contenant les informations de la facture du cavalier.
         */
        public function creationFactureCavalier(FactureCavalierRequest $request);

        /**
         * Crée une facture pour un événement spécifique.
         *
         * @param int|string $evenement_id Identifiant de l'événement concerné.
         */
        public function creationFactureEvnement($evenement_id);

        /**
         * Supprime une facture liée à un cavalier spécifique.
         *
         * @param int|string $cavalier_id Identifiant du cavalier concerné.
         */
        public function delete_by_cavalier($cavalier_id);

        /**
         * Supprime une facture liée à un événement spécifique.
         *
         * @param int|string $evenement_id Identifiant de l'événement concerné.
         */
        public function delete_by_evenement($evenement_id);
    }
}
