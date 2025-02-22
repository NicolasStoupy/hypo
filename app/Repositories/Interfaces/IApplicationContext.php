<?php

namespace App\Repositories\Interfaces {
    /**
     * Interface IApplicationContext
     *
     * Cette interface définit les services accessibles dans le contexte de l'application.
     */
    interface IApplicationContext
    {
        public function poney(): IPoney;
        public function client(): IClient;
        public function evenement():IEvenement;
        public function facture():IFacture;
        public function status() :IStatus;

        public function openHours():IOpenHours;

        public function cleaning():ICleanning;

    }
}
