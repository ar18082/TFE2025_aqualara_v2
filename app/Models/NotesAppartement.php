<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesAppartement extends Model
{
    use HasFactory;

    protected $fillable = [
        'appartement_id',
        'type',
        'note',
        'user_id',
    ];

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appareil()
    {
        return $this->belongsTo(Appareil::class);
    }
}
