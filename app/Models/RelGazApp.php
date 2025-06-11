<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelGazApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Codecli',
        'RefAppTR',
        'DatRel',
        'FraisDiv',
        'Rem1',
        'Rem2',
        'PctFraisAnn',
        'NbCpt',
        'RmqOcc',
        'NbFraisTR',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'RefAppTR', 'RefAppTR');
    }

}
