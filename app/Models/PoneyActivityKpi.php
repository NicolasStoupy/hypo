<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoneyActivityKpi extends Model
{
    protected $table = 'poneys_activity_kpi';

    public $timestamps = false;
    // Empêcher l'insertion et la mise à jour
    protected $guarded = [];
    protected $fillable = ['nom', 'year_week', 'total_hours'];
}
