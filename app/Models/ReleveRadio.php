<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveRadio extends Model
{
    use HasFactory;

    protected $table = 'releveRadio';


    protected $fillable = [
        'Codecli', 'Numcal', 'TypeLecture', 'Status', 'DateRel', 'Ind'
    ];


    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }
}
