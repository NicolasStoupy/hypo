<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cavalier extends Model
{
    protected $fillable = [
        'nom',
        'evenement_id'
    ];


    public function evenement(){
        return $this->belongsTo(Evenement::class);
    }

    public function facture(){

        return $this->hasOne(Facture::class, 'id', 'facture_id');
    }

}
