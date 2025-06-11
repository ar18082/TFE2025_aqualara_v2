<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecDateProvisoire extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dec_date_provisoire';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codecli',
        'date_debut',
        'date_fin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];
} 