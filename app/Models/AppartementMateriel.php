<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppartementMateriel extends Model
{
    use HasFactory;
    protected $table = 'appartement_materiel';
    protected $fillable = [
        'appartement_id',
        'materiel_id',
        'referenceMateriel'
    ];

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}
