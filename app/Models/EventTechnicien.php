<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTechnicien extends Model
{
    use HasFactory;
    protected $table = 'event_technicien';

    protected $fillable = [
        'event_id',
        'technicien_id',
        'role',
    ];

    public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'technicien_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
