<?php

namespace App\Repositories\Interfaces {

    interface IRepository
    {

        public function getAll();
        public function paginate($perPage,$shearch);

        public function deleteById($id);

        public function getById($id);




    }
}
