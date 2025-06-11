<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelElecApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Codecli',
        'RefAppTR',
        'NumCpt',
        'DatRel',
        'FraisDiv',
        'Rem1',
        'Rem2',
        'PctFraisAnn',
        'NbCpt',
        'Statut',
        'RmqOcc',
        'NbFraisTR',

    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
