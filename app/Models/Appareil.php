<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appareil extends Model
{
    use HasFactory;
    protected $table = 'appareils';
    protected $fillable = [
        'codeCli',
        'RefAppTR',
        'numSerie',
        'TypeReleve',
        'coef',
        'sit',
        'numero',
        'materiel_id',


    ];

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id',);
    }

    public function appareilsErreurs()
    {
        return $this->hasMany(AppareilsErreur::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'codeCli', 'Codecli');
    }

    public function notesAppartements()
    {
        return $this->hasMany(NotesAppartement::class);
    }

    public function fileStorage()
    {
        return $this->hasMany(FileStorage::class);
    }


}
