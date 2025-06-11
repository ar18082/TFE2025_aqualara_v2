<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelElec extends Model
{
    use HasFactory;
    protected $table = 'rel_elecs';
    protected $fillable = [
        'id',
        'Codecli',
        'RefAppTR',
        'DatRel',
        'AncIdx',
        'NvIdx',
        'NoCpt',
        'NvIdx2',
        'Sit',
        'Statut',
        'ProprioCd',
        'GerantCd',
        'Ok_Site',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'RefAppTR', 'RefAppTR');
    }
}
