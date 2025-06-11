<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'content',
        'type_event_id',
    ];

    /**
     * Relation avec TypeEvent.
     */
    public function typeEvent()
    {
        return $this->belongsTo(TypeEvent::class, 'type_event_id');
    }
}
