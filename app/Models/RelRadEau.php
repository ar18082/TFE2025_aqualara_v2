<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelRadEau extends Model
{
    use HasFactory;

    protected $table = 'rel_rad_eaus';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'Numcal', 'Nvidx', 'StatutImp', 'DatRelFich',
        'FileName', 'NumImp', 'Erreur', 'StatutRel', 'RelPrinc', 'DatImp', 'hh_imp',
        'mm_imp', 'Ok_Site', 'Ch_Fr', 'AncIdx',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
