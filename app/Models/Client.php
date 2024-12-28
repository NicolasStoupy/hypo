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

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');

    }

    public function evenements():HasMany
    {
        return $this->hasMany(Evenement::class, 'client_id');
    }
}
