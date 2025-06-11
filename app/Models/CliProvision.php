<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CliProvision extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Codecli',
        'ProvDtFr',
        'MontProv',
        'TypClac',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
