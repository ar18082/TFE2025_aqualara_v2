<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;

   protected $fillable = ['CodeCli', 'RefAppTR', 'proprietaire', 'RefAppCli'];

    protected $attributes = [
        'datefin' => '9999-12-31',
        'lancod' => 0,
        'bloc' => 0,
        'Cellule' => '',
        'created_at' => null,
        'updated_at' => null,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Codecli', 'Codecli');
    }

    public function notesAppartements()
    {
        return $this->hasMany(NotesAppartement::class);
    }

    public function notesCH()
    {
        // return last note of type CHF
        return $this->notesAppartements()->where('type', 'CHF')->orderBy('created_at', 'desc')->first();
    }

    public function notesEC()
    {
        // return last note of type EC
        return $this->notesAppartements()->where('type', 'EC')->orderBy('created_at', 'desc')->first();
    }

    public function notesEF()
    {
        // return last note of type EF
        return $this->notesAppartements()->where('type', 'EF')->orderBy('created_at', 'desc')->first();
    }

    public function Absent()
    {
        return $this->hasMany(Absent::class);
    }

    public function fileStorages()
    {
        return $this->hasMany(FileStorage::class, 'codeCli', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventAppartements()
    {
        return $this->belongsTo(EventAppartement::class);
    }

    public function materiels()
    {
        return $this->belongsToMany(Materiel::class, 'appartement_materiel')
            ->withPivot('referenceMateriel')
            ->withTimestamps();
    }

    // relation avec la table XXXXXApps
    public function relApps()
    {
        return $this->hasMany(relApp::class, 'RefAppTR', 'RefAppTR');
    }

    public function relChaufApps()
    {
        return $this->hasMany(RelChaufApp::class, 'Codecli', 'Codecli', 'RefAppTR', 'RefAppTR');
    }

    public function relEauApps()
    {
        return $this->hasMany(RelEauApp::class, 'RefAppTR', 'RefAppTR');
    }

    public function relGazApps()
    {
        return $this->hasMany(RelGazApp::class, 'RefAppTR', 'RefAppTR');
    }

    public function relElecApps()   
    {
        return $this->hasMany(RelElecApp::class, 'RefAppTR', 'RefAppTR');
    }

    public function relChaufs()
    {
        return $this->hasMany(RelChauf::class, 'RefAppTR', 'RefAppTR');
    }

    

    
    




}
