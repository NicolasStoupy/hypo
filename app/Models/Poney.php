<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poney extends Model
{
    use HasFactory;

    protected $table = 'poneys';

    protected $fillable = [
        'nom',
        'max_hour_by_day',
        'created_by',
    ];
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where('nom', 'like', "%$term%")
                ->orWhere('max_hour_by_day', 'like', "%$term%")
                // Recherche dans la relation Evenement
                ->orWhereHas('evenements', function ($q) use ($term) {
                    $q->where('prix', 'like', "%$term%")
                        ->orWhere('nombre_participant', 'like', "%$term%")
                        ->orWhere('date_debut', 'like', "%$term%")
                        ->orWhere('date_fin', 'like', "%$term%");
                });
        }

        return $query;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, 'evenement_poneys', 'poney_id', 'evenement_id')
            ->withTimestamps();
    }

}

