<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'factures';
    protected $primaryKey ='id';
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
        return $this->hasOne(User::class, 'id');
    }

    public function evenements(): HasMany
    {
        return $this->hasMany(Evenement::class, "facture_id");
    }

    public function total(){
        return $this->evenements()->sum('prix');
    }
}
