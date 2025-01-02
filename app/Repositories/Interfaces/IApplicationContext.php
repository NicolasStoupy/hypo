<?php

namespace App\Repositories\Interfaces {

    interface IApplicationContext
    {
        public function poney(): IPoney;
        public function client(): IClient;
        public function evenement():IEvenement;
        public function facture():IFacture;
        public function status() :IStatus;

        public function beginTransaction(): void;
        public function commit(): void;
        public function rollback(): void;


    }
}
