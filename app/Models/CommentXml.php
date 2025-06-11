<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentXml extends Model
{
    // Spécifie la table associée au modèle
    protected $table = 'commentaire_xml';

    // Indique si la table a des colonnes created_at et updated_at
    public $timestamps = true;

    // Liste des attributs pouvant être affectés de manière massive
    protected $fillable = [
        'commentaire',
        'fileName'
    ];

}
