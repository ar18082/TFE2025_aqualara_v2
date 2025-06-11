<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clichauf extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'Codecli',
        'Quotite',
        'PctPrive',
        'PctCom',
        'TypCal',
        'FraisTR',
        'FraisAnn',
        'Consom',
        'Periode',
        'UniteAnn',
        'TypRep',
        'ConsPrive',
        'ConsComm',
        'TypRlv',
        'DatePlacement',
        'created_at',
        'updated_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
