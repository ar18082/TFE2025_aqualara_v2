<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeErreur extends Model
{
    use HasFactory;

    protected $fillable = [
        'appareil',
        'nom',

    ];



}
