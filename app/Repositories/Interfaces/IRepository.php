<?php

namespace App\Repositories\Interfaces {

    interface IRepository
    {

        public function getAll();

        /**
         * Récupère les entités paginées avec un critère de recherche.
         *
         * @param int $perPage Nombre d'entités par page.
         * @param string|null $search Terme de recherche.
         * @return mixed
         */
        public function paginate($perPage, $search);

        /**
         * Supprime une entité par son identifiant.
         *
         * @param int|string $id Identifiant de l'entité à supprimer.
         * @return bool
         */
        public function deleteById($id);

        /**
         * Récupère une entité par son identifiant.
         *
         * @param int|string $id Identifiant de l'entité à récupérer.
         * @return mixed
         */
        public function getById($id);


    }
}
