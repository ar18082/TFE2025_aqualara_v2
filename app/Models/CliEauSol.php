<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CliEauSol extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'libelle',
        'consoMax',
        'prixU',
    ];

    public function client()
    {
        return $this->hasMany(Client::class, 'Codecli', 'Codecli');
    }
}
