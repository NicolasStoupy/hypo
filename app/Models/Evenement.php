<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = [
        'prix',
        'date_fin',
        'date_debut',
        'nombre_participant',
        'facture_id',
        'client_id',
        'created_by',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function poneys()
    {
        return $this->belongsToMany(Poney::class, 'evenement_poneys', 'evenement_id', 'poney_id');
    }


}
