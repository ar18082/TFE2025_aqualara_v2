<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name'];



    public function techniciens()
    {
        return $this->belongsToMany(Technicien::class, 'technicien_region', 'region_id', 'technicien_id');
    }

}
