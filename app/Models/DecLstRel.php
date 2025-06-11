<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecLstRel extends Model
{
    use HasFactory;
    protected $fillable = [
        'refAppTR',
        'Codecli',
        'datRelChf',
        'datRelEau',
        'datRelGaz',
        'datRelElec',
        'rmqOcc',
        'debPer',
        'finPer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'refAppTR', 'RefAppTR');
    }


}
