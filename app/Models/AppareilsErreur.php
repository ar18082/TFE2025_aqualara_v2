<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppareilsErreur extends Model
{
    use HasFactory;
    protected $table = 'appareils_erreurs';
    protected $fillable = [
        'appareil_id',
        'type_erreur_id',

    ];

    public function typeErreur()
    {
        return $this->belongsTo(typeErreur::class);
    }
    public function appareil()
    {
        return $this->belongsTo(Appareil::class);
    }
}
