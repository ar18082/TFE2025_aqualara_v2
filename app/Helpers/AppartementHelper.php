<?php

namespace App\Helpers;

use App\Models\Appartement;

class AppartementHelper
{
    public static function getAppartementsWithAbsent($codecli)
    {
        $appartements = Appartement::where('Codecli', $codecli)
            ->with('Absent')
            ->get();

        $nbImmAbsent = 0;
        foreach ($appartements as $appartement) {
            if ($appartement->Absent->count() > 0 && $appartement->Absent->first()->is_absent) {
                $nbImmAbsent++;
            }
        }

        return compact('appartements', 'nbImmAbsent');
    }
} 