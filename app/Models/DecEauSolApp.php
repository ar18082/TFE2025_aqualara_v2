<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecEauSolApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Codecli',
        'libelle',
        'consoMax',
        'prixU',
        'refAppTR',
        'datRel',
        'nbrHlFac',
        'consoMin',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'refAppTR', 'RefAppTR');
    }
}
