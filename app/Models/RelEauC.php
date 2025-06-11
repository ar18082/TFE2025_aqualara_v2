<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelEauC extends Model
{
    use HasFactory;

    protected $table = 'rel_eau_c_s';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'NumCpt', 'NoCpt', 'AncIdx', 'NvIdx',
        'Sit', 'NvIdx2', 'TypCal', 'Statut', 'Envers', 'NumImp', 'DatImp',
        'hh_imp', 'mm_imp', 'Ok_Site',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function cliEau()
    {
        return $this->belongsTo(CliEau::class, 'Codecli', 'Codecli');
    }
}
