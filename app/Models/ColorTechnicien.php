<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorTechnicien extends Model
{
    use HasFactory;
    protected $table = 'couleur_technicien';


    public function techniciens()
    {
        return $this->hasMany(Technicien::class, 'couleur_id');
    }


}

