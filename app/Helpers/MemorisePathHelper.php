<?php

namespace App\Helpers;

class  MemorisePathHelper
{
    // Fonction pour mémoriser un chemin
    public static function savePath($url)
    {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session(['my_path'=> $url]);



    }

    // Fonction pour récupérer les chemins mémorisés
    public static function getLastPath()
    {

        if (session('my_path') !== null) {
            return session('my_path');
        }else{
            return "/";
        }
    }


}
