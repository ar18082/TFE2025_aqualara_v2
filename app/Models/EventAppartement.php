<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAppartement extends Model
{
    use HasFactory;
    protected $table = 'event_appartement';

    protected $fillable = [
        'event_id',
        'appartement_id',

    ];
}
