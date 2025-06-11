<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerantImm extends Model
{
    use HasFactory;

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'codgerant', 'Codegerant');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
