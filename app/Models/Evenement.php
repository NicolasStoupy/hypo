<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'nom',
        'date_evenement',
        'status_id', 'evenement_type_id'
    ];

    public function scopeSearch($query, $term)
    {

        if ($term) {
            return $query->where('prix', 'like', "%$term%")
                ->orWhere('nom', 'like', "%$term%")
                ->orWhere('nombre_participant', 'like', "%$term%")
                ->orWhere('date_debut', 'like', "%$term%")
                ->orWhere('date_fin', 'like', "%$term%")
                ->orWhereHas('client', function ($q) use ($term) {
                    $q->where('nom', 'like', "%$term%");
                })
                ->orWhereHas('facture', function ($q) use ($term) {
                    $q->where('id', 'like', "%$term%");
                });
        }

        return $query;
    }

    /**
     * Relation avec la facture associée à l'événement.
     *
     * @return BelongsTo
     */
    public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id');
    }

    /**
     * Relation avec les cavaliers participant à l'événement.
     *
     * @return HasMany
     */
    public function cavaliers()
    {
        return $this->hasMany(Cavalier::class, 'evenement_id');
    }

    /**
     * Relation avec le client associé à l'événement.
     *
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Relation avec l'utilisateur qui a créé l'événement.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation avec les poneys associés à l'événement via une table pivot.
     *
     * @return BelongsToMany
     */
    public function poneys()
    {
        return $this->belongsToMany(Poney::class, 'evenement_poneys', 'evenement_id', 'poney_id');
    }

    /**
     * Relation avec le statut de l'événement.
     *
     * @return HasOne
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'id', localKey: 'status_id');
    }

    /**
     * Relation avec le type d'événement.
     *
     * @return HasOne
     */
    public function evenement_type()
    {
        return $this->hasOne(EvenementType::class, 'id', 'evenement_type_id');
    }

    /**
     * Retourne la plage horaire de l'événement au format HH:mm à HH:mm.
     *
     * @return string
     */
    public function getTimeRange(): string
    {
        $start = Carbon::parse($this->date_debut);
        $end = Carbon::parse($this->date_fin);

        return $start->format('H:i') . ' à ' . $end->format('H:i');
    }

    /**
     * Retourne la durée de l'événement sous forme d'objet DateInterval.
     *
     * @return \DateInterval
     */
    public function getDuration(): string
    {
        $start = Carbon::parse($this->date_debut);
        $end = Carbon::parse($this->date_fin);

        $difference = $start->diff($end);
        return $difference;
    }

    /**
     * Vérifie si l'événement est prévu pour aujourd'hui.
     *
     * @return bool
     */
    public function isToday(): bool
    {
        return Carbon::parse($this->date_debut)->isToday();
    }

    /**
     * Vérifie si l'événement est en cours (arrondi à 15 minutes près).
     *
     * @return bool
     */
    public function isNow(): bool
    {
        // Arrondir la date_debut et l'heure actuelle à 15 minutes près
        $roundedDateDebut = Carbon::parse($this->date_debut)->floor('15 minutes');
        $roundedNow = Carbon::now()->floor('15 minutes');

        return $roundedDateDebut->eq($roundedNow);
    }

    /**
     * Calcule le prix par cavalier.
     *
     * @return float|null
     */
    public function get_separed_price()
    {
        return $this->prix / $this->cavaliers->count();
    }

    /**
     * Retourne la quantité de poneys sélectionnés pour l'événement.
     *
     * @return int
     */
    public function qtyOfPoneysSelected(): int
    {
        return $this->poneys->count();
    }

    /**
     * Retourne la liste des poneys disponibles (non assignés à un autre événement).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get_poneys_availaible()
    {

        // Récupérer les poneys déjà assignés à un événement
        $poney_event = $this->poneys()->pluck('id'); // Récupère les IDs des poneys assignés

        // Récupérer les poneys non assignés
        $available_poneys = Poney::whereNotIn('id', $poney_event)->get();

        return $available_poneys;
    }

    /**
     * Calcule le montant restant à facturer après les paiements des cavaliers et du client.
     *
     * @return float
     */
    public function remaining_to_bill()
    {

        $paid_by_cavaliers = $this->cavaliers->sum(function ($cavalier) {
            return $cavalier->facture->amount ?? 0;
        });
        $paid_by_client = $this->facture->amount ?? 0;
        return $this->prix - $paid_by_cavaliers - $paid_by_client;
    }

    /**
     * Vérifie si l'événement peut être supprimé (aucune facture associée).
     *
     * @return bool
     */
    public function hasDeletable()
    {

        return $this->facture_id === null;
    }


}
