<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvenementPoney extends Model
{

    use HasFactory;
    protected $table = 'evenement_poneys';

    protected $fillable = [
        'evenement_id',
        'poney_id',
        'Createdby',
    ];
    /**
     * Relation avec l'événement associé.
     *
     * @return BelongsTo
     */
    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }
    /**
     * Relation avec le poney associé.
     *
     * @return BelongsTo
     */
    public function poney()
    {
        return $this->belongsTo(Poney::class, 'poney_id');
    }
    /**
     * Relation avec l'utilisateur qui a créé l'enregistrement.
     *
     * @return BelongsTo
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
