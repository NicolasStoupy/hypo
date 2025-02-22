<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View_availaibility extends Model
{
    // Indiquer le nom de la vue (et non une table)
    protected $table = 'view_availaibility';

    // Désactiver la gestion automatique des timestamps (car la vue n'a pas ces colonnes)
    public $timestamps = false;


    protected $fillable = []; // Aucune colonne n'est remplissable, juste pour éviter les erreurs d'insertion
}
