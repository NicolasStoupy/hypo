<?php

namespace App\Repositories\Interfaces {

    use App\Http\Requests\ClientRequest;

    interface ICleanning extends IRepository
    {

        /**
         * Assigne un poney à un box spécifique.
         *
         * Cette méthode associe un poney, identifié par son ID, à un box identifié par son ID.
         *
         * @param int $box_id L'ID du box auquel le poney sera assigné.
         * @param int $poney_id L'ID du poney à assigner au box.
         */
        public function AssignPoneyBox($box_id, $poney_id);

        /**
         * Retire un poney d'un box.
         *
         * Cette méthode dissocie un poney, identifié par son ID, d'un box.
         *
         * @param int $poney_id L'ID du poney à retirer du box.
         */
        public function RemovePoneyBox($poney_id);

        /**
         * Nettoie un box spécifique.
         *
         * Cette méthode nettoie le box identifié par son ID.
         *
         * @param int $box_id L'ID du box à nettoyer.
         */
        public function CleanBox($box_id);

        /**
         * Crée un nouveau box.
         *
         * Cette méthode crée un nouveau box de nettoyage.
         */
        public function NewBox();

        /**
         * Supprime un box spécifique.
         *
         * Cette méthode supprime un box, identifié par son ID.
         *
         * @param int $id L'ID du box à supprimer.
         */
        public function DeleteBox($id);



    }
}
