<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    use HasFactory;

    public static function findByType($typeIntervention)
    {
        return self::where('name', $typeIntervention)->first();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function avisPassageTexts()
    {
        return $this->hasMany(AvisPassageText::class);
    }

    public function mailContents()
    {
        return $this->hasMany(MailContent::class, 'type_event_id');
    }
}
