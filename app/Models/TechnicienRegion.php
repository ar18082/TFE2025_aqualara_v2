<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicienRegion extends Model
{
    use HasFactory;

    protected $table = 'technicien_region';

    protected $fillable = [
        'technicien_id',
        'region_id',
        'priorite',
    ];
}
