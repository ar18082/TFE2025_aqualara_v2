<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];

    public function techniciens()
    {
        return $this->belongsToMany(Technicien::class, 'technicien_competence', 'competence_id', 'technicien_id');
    }
}
