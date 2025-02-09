<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    /**
     * Affiche la liste des configurations.
     *
     * Cette méthode récupère toutes les configurations depuis la base de données,
     * les transforme en un tableau associatif où chaque clé est le `key` de la configuration,
     * et retourne la vue `config.index` avec ces données.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère toutes les configurations et les transforme en un tableau associatif
        $config = Config::all()->mapWithKeys(function ($item) {
            return [
                $item->key => [
                    'value' => $item->value,
                    'type' => $item->type,
                    'documentation'=> $item->documentation
                ]
            ];
        });

        // Retourne la vue avec les configurations
        return view('config.index', compact('config'));
    }

    /**
     * Met à jour les configurations existantes ou les crée si elles n'existent pas.
     *
     * Cette méthode récupère les données envoyées via la requête HTTP, les parcourt
     * et met à jour ou crée les enregistrements correspondants dans la table `Config`.
     * Elle convertit également les valeurs en fonction de leur type avant de les sauvegarder.
     *
     * @param \Illuminate\Http\Request $request La requête contenant les configurations à mettre à jour.
     * @return \Illuminate\Http\JsonResponse Une réponse JSON confirmant la mise à jour.
     */
    public function update(Request $request)
    {
        $configs = Config::all();

        foreach ($configs as $config){
            $newConfig = $request->Get($config->key);
            if ($newConfig){
                $config->value=$newConfig;
            }
            $config->save();
        }

        // Retourne une réponse JSON de confirmation
        return $this->index()->with('success','Mise a jour effetuée avec success');
    }


}
