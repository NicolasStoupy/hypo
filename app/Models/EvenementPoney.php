<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvenementPoney extends Model
{

    use HasFactory;
    protected $table = 'evenement_poneys';

    protected $fillable = [
        'evenement_id',
        'poney_id',
        'Createdby',
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    public function poney()
    {
        return $this->belongsTo(Poney::class, 'poney_id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
