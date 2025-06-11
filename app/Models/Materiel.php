<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'genre',
        'type',
        'dimension',
        'communication',
        'model',
        'temps_lecture',
        'temps_montage',
    ];

    public function appartements()
    {
        return $this->belongsToMany(Appartement::class, 'appartement_materiel')
            ->withPivot('referenceMateriel')
            ->withTimestamps();
    }

    public function appareils()
    {
        return $this->hasMany(Appareil::class, 'materiel_id');
    }
}
