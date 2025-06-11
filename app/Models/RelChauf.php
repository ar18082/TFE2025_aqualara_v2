<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelChauf extends Model
{
    use HasFactory;

    protected $table = 'rel_chaufs';

    protected $fillable = [
        'Codecli', 'RefAppTR', 'DatRel', 'NumRad', 'NumCal', 'AncIdx', 'NvIdx', 'Coef',
        'Sit', 'NvIdx2', 'TypCal', 'Statut', 'NumImp', 'DatImp', 'hh_imp', 'mm_imp', 'Ok_Site',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
