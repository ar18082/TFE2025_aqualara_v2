<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use HasFactory;

    protected $table = 'absent';

    protected $fillable = [
        'appartement_id',
        'user_id',
        'is_absent',
    ];

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
