<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelEauApp extends Model
{
    use HasFactory;

    protected $table = 'rel_eau_apps';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'FraisDiv', 'Rem1', 'Rem2',
        'PctFraisAnn', 'NbCptFroid', 'NbCptChaud', 'RmqOcc', 'NbFraisTR',
        'NbFraisTRF', 'NbPers',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
