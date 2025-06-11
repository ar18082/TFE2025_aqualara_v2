<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelGaz extends Model
{
    use HasFactory;
    protected $table = 'rel_gaz';

    protected $fillable = [
        'id',
        'Codecli',
        'RefAppTR',
        'DatRel',
        'NumCpt',
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
