<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelChaufApp extends Model
{
    use HasFactory;

    protected $table = 'rel_chauf_apps';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'FraisDiv', 'Rem1', 'Rem2', 'NbRad',
        'PctFraisAnn', 'RmqOcc', 'NbFraisTR', 'AppQuot',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
