<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CliEau extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'Codecli', 'PrxFroid', 'PrxChaud', 'TypCpt', 'FraisTR', 'FraisAnn',
        'Consom', 'Unite', 'SupChaud', 'Periode', 'typcalc_', 'UnitAnn', 'typcalc',
        'ChaudChf', 'EauSol', 'TypRlv', 'DatePlacement',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
