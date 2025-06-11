<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [

        'Codecli',
        'nom',
        'rue',
        'codePost',
        'codepays',
        'tel',
        'fax',
        'email',
        'latitude',
        'longitude',
        'rueger',
        'dernierreleve'

    ];
    public static function findByCode($codeCli)
    {
        return self::where('codeCli', $codeCli)->first();
    }

    public function gerantImms()
    {
        return $this->hasMany(GerantImm::class, 'Codecli', 'Codecli');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'nom', 'gerant');
    }

    public function appProprios()
    {
        return $this->hasMany(app_proprio::class, 'Codecli', 'Codecli');
    }

    public function appartements()
    {
        return $this->hasMany(Appartement::class, 'Codecli', 'Codecli');
    }

    public function relApps()
    {
        return $this->hasMany(relApp::class, 'Codecli', 'Codecli');
    }

    public function codePostelbs()
    {
        return $this->belongsToMany(CodePostelb::class, 'client_code_postelb');
    }

    public function clichaufs()
    {
        return $this->hasMany(Clichauf::class, 'client_id');
    }

    public function cliEaus()
    {
        return $this->hasMany(CliEau::class);
    }

    public function cliProvisions()
    {
        return $this->hasMany(CliProvision::class, 'Codecli', 'Codecli');
    }

    public function cliElecs()
    {
        return $this->hasMany(CliElec::class, 'Codecli', 'Codecli');
    }

    public function cliGazs()
    {
        return $this->hasMany(CliGaz::class, 'Codecli', 'Codecli');
    }

    public function relRadChfs()
    {
        return $this->hasMany(RelRadChf::class, 'Codecli', 'Codecli');
    }

    public function relRadEaus()
    {
        return $this->hasMany(RelRadEau::class, 'Codecli', 'Codecli');
    }

    public function relChaufApps()
    {
        return $this->hasMany(RelChaufApp::class, 'Codecli', 'Codecli');
    }

    public function relEauApps()
    {
        return $this->hasMany(RelEauApp::class, 'Codecli', 'Codecli');
    }

    public function relElecApps()
    {
        return $this->hasMany(RelElecApp::class, 'Codecli', 'Codecli');
    }

    public function relGazApps()
    {
        return $this->hasMany(RelGazApp::class, 'Codecli', 'Codecli');
    }

    public function relChaufs()
    {
        return $this->hasMany(RelChauf::class, 'Codecli', 'Codecli');
    }

    public function relEauCs()
    {
        return $this->hasMany(RelEauC::class, 'Codecli', 'Codecli');
    }

    public function relEauFs()
    {
        return $this->hasMany(RelEauF::class, 'Codecli', 'Codecli');
    }

    public function relGazs()
    {
        return $this->hasMany(RelGaz::class, 'Codecli', 'Codecli');
    }

    public function relElecs()
    {
        return $this->hasMany(RelElec::class, 'Codecli', 'Codecli');

    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function appareils()
    {
        return $this->hasMany(Appareil::class, 'codeCli', 'Codecli');
    }

    public function notes()
    {
        return $this->hasMany(NotesAppartement::class);
    }




}
