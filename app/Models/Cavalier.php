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

}
