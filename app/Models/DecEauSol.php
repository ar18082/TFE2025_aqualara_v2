<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecEauSol extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Codecli',
        'libelle',
        'consoMax',
        'prixU',

    ];
}
