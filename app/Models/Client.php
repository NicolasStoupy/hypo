<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'nom',
        'email',
        'created_by',
    ];

    /**
     * Relation avec l'utilisateur qui a créé cet enregistrement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');

    }
    /**
     * Relation avec les événements associés à ce client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evenements(): HasMany
    {
        return $this->hasMany(Evenement::class, 'client_id');
    }
    /**
     * Relation avec les factures associées à ce client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factures()
    {

        return $this->hasMany(Facture::class, 'client_id');

    }
    /**
     * Vérifie si l'entité peut être supprimée.
     * Un client est supprimable s'il n'a ni factures ni événements associés.
     *
     * @return bool
     */
    public function hasDeletable()
    {

        return $this->factures->count() === 0 && $this->evenements->count() === 0;
    }
}
