<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturier_client extends Model
{
    protected $table = 'facturier_client';

    public $timestamps = false;
    // Empêcher l'insertion et la mise à jour
    protected $guarded = [];
}
