<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AvisPassageText extends Model
{
    use HasFactory;
    protected $fillable = [
        'typePassage',
        'acces',
        'presence',
        'coupure',
        'type_event_id',
        'TypRlv',
    ];

    public function typeEvent()
    {
        return $this->belongsTo(TypeEvent::class);
    }
}
