<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecEntete extends Model
{
    use HasFactory;
    protected $fillable = [
        'chfConsCom',
        'chfNbQuot',
        'chfPUQot',
        'chfConsPrive',
        'chfNbDiv',
        'chfPUDiv',
        'eauUnit',
        'eauCCons',
        'eauCm3',
        'eauCPU',
        'eauFCons',
        'eauFm3',
        'eauFPU',
        'gazCons',
        'gazm3',
        'gazPU',
        'elecCons',
        'elecKW',
        'elecPU',
        'chfFrRel',
        'chFNbRel',
        'chPURel',
        'eauCFrRel',
        'eauCNbRel',
        'eauCPURe',
        'eauFFrRel',
        'eauFNbRel',
        'gazFrRel',
        'gazNbRel',
        'gazPURel',
        'elecFrRel',
        'elecNbRel',
        'elecPURel',
        'FrDiv',
        'FrDivNb',
        'FrDivPU',
        'chfFrAnnLib',
        'chfFrAnn',
        'chfFrAnnNb',
        'chfFrAnnPU',
        'eauFrAnnLib',
        'eauFrAnn',
        'eauFrAnnNb',
        'eauFrAnnPU',
        'gazFrAnnLib',
        'gazFrAnn',
        'gazFrAnnNb',
        'gazFrAnnPU',
        'elecFrAnnLib',
        'elecFrAnn',
        'elecFrAnnNb',
        'elecFrAnnPU',
        'provTotCle',
        'Codecli',
        'debPer',
        'finPer',
        'statut',
        'chfFrDiv',
        'eauFrDiv',
        'gazFrDiv',
        'elecFrDiv',
        'typCalc',
        'eauSol',


    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
