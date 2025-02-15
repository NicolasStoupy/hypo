<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyOpeningHour extends Model
{
    use HasFactory;

    protected $fillable = ['week_number', 'year', 'day', 'open_time', 'close_time', 'is_closed'];
}
