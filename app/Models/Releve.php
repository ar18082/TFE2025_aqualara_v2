<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Releve extends Model
{
    use HasFactory;
    protected $table = 'releves';

    protected $fillable = [
        'appareil_id',
        'DatRel',
        'index',
        'statutImp',
        'DatRelFich',
        'FileName',
        'NumImp',
        'Erreur',
        'statutRel',
        'RelPrinc',
        'DatImp',
        'hh_imp',
        'mm_imp',
        'Ok_Site',
    ];

    public function appareil()
    {
        return $this->belongsTo(Appareil::class);
    }
}
