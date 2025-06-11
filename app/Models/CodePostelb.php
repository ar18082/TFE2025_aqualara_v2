<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePostelb extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_code_postelb');
    }
}
