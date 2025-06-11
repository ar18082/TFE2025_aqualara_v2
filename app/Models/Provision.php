<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provision extends Model
{
    protected $table = 'provisions';
    
    protected $fillable = [
        'Codecli',
        'RefAppTR',
        'montant',
        'type_repartition',
        'date_decompte'
    ];

    protected $casts = [
        'date_decompte' => 'date',
        'montant' => 'decimal:2'
    ];
} 