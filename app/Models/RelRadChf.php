<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelRadChf extends Model
{
    use HasFactory;

    protected $table = 'rel_rad_chfs';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'Numcal', 'Nvidx', 'StatutImp', 'DatRelFich',
        'FileName', 'NumImp', 'Erreur', 'StatutRel', 'RelPrinc', 'DatImp', 'hh_imp',
        'mm_imp', 'Ok_Site', 'Coef', 'AncIdx',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
