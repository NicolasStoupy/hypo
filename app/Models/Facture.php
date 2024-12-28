<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'factures';

    /**
     * Relation avec le modèle Client.
     * Chaque facture appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec le modèle User.
     * Chaque facture est créée par un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }
}
