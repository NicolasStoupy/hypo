<?php

namespace App\Helpers;

use App\Models\Config;

 class ConfigHelper
{

     // Méthode statique pour récupérer une valeur de configuration
     public static function get(string $key) :string
     {
         // Accéder directement à la base de données via le modèle Config
         return Config::where('key', $key)->first()->value ?? '';
     }


}
