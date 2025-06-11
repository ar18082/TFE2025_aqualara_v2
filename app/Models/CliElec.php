<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CliElec extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'Codecli',
        'Prix',
        'TypCpt',
        'FraisTR',
        'FraisAnn',
        'Consom',
        'Periode',
        'typcalc',
        'UnitAnn',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
