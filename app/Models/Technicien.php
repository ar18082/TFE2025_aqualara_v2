<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    protected $table = 'techniciens';
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'couleur_id',
        'phone',
        'statut_id',
        'registre_national',
        'rue',
        'numero',
        'code_postal',
        'localite'

    ];


   /* public function regions()
    {
        return $this->belongsToMany(Region::class, 'technicien_region', 'technicien_id', 'region_id');
    }*/
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'technicien_region', 'technicien_id', 'region_id')
            ->withPivot('priorite'); // Ajoutez cette méthode pour inclure la colonne priorite de la table de pivot
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'technicien_competence', 'technicien_id', 'competence_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_technicien', 'technicien_id', 'event_id');
    }

    public function status()
    {
        return $this->belongsTo(statusTechnicien::class, 'status_id');
    }
    public function colorTechnicien()
    {
        return $this->belongsTo(ColorTechnicien::class, 'couleur_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
