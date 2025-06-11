<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class app_proprio extends Model
{
    use HasFactory;

    //    protected $fillable = [
    //        'Codecli',
    //        'RefAppTR',
    //        'Propriocd',
    //        'DatDeb',
    //        'DatFin',
    //    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function app_proprio()
    {
        return $this->belongsTo(App_proprio::class, 'RefAppTR', 'RefAppTR');
    }
}
