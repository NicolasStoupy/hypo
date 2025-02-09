<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cavalier extends Model
{
    protected $fillable = [
        'nom',
        'evenement_id'
    ];

    /**
     * Définir la relation "appartient à" avec le modèle Evenement.
     *
     * Cette méthode définit la relation entre le modèle actuel et le modèle `Evenement`.
     * Elle indique que chaque instance du modèle actuel appartient à un événement spécifique.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *         La relation `BelongsTo` indiquant que chaque enregistrement de ce modèle
     *         est lié à un seul événement.
     */
    public function evenement(){
        return $this->belongsTo(Evenement::class);
    }
    /**
     * Définir la relation "a une" avec le modèle Facture.
     *
     * Cette méthode définit la relation entre le modèle actuel et le modèle `Facture`.
     * Elle indique que chaque instance du modèle actuel a une facture associée.
     * La clé étrangère pour cette relation est `facture_id`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *         La relation `HasOne` indiquant que chaque enregistrement de ce modèle
     *         a une seule facture associée.
     */
    public function facture(){

        return $this->hasOne(Facture::class, 'id', 'facture_id');
    }

}
