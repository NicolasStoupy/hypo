<?php

namespace App\Models;

use Carbon\Carbon;
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
        'nom',
        'date_evenement',
        'status_id','evenement_type_id'
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

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id');
    }
    public function cavaliers()
    {
        return $this->hasMany(Cavalier::class,'evenement_id');
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

    public function status()
    {
        return $this->hasOne(Status::class, 'id', localKey: 'status_id');
    }

    public function evenement_type()
    {
        return $this->hasOne(EvenementType::class,'id','evenement_type_id');
    }

    public function getTimeRange(): string
    {
        $start = Carbon::parse($this->date_debut);
        $end = Carbon::parse($this->date_fin);

        return $start->format('H:i') . ' à ' . $end->format('H:i');
    }
    public function getDuration(): string
    {
        $start = Carbon::parse($this->date_debut);
        $end = Carbon::parse($this->date_fin);

        $difference = $start->diff($end);
        return $difference;
    }
    public function isToday(): bool
    {
        return Carbon::parse($this->date_debut)->isToday();
    }

    public function isNow(): bool
    {
        // Arrondir la date_debut et l'heure actuelle à 15 minutes près
        $roundedDateDebut = Carbon::parse($this->date_debut)->floor('15 minutes');
        $roundedNow = Carbon::now()->floor('15 minutes');

        return $roundedDateDebut->eq($roundedNow);
    }

    public function qtyOfPoneysSelected(): int
    {
       return  $this->poneys->count() ;
    }

    public function get_poneys_availaible(){

        // Récupérer les poneys déjà assignés à un événement
        $poney_event = $this->poneys()->pluck('id'); // Récupère les IDs des poneys assignés

        // Récupérer les poneys non assignés
        $available_poneys = Poney::whereNotIn('id', $poney_event)->get();

        return $available_poneys;
    }

    public function hasDeletable(){

        return $this->facture_id === null;
    }


}
