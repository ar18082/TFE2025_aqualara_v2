<?php

namespace App\Http\Controllers\Saisie;

use App\Http\Controllers\Controller;
use App\Models\RelChauf;
use Illuminate\Http\Request;

class GestionStatutController extends Controller
{
   
    public function nouveauStatut(Request $request)
    {
        dd($request->all());
        $type = $request->type;
        $codecli = $request->codecli;
        $numeroSerie = $request->numeroSerie;
        $date = $request->date;
        $index = $request->index;
        $refAppTR = $request->refAppTR;

        $relchauf = RelChauf::where('Codecli', $codecli)->where('RefAppTR', $refAppTR)->first();
        $newRelChauf = new RelChauf();

        return response()->json(['message' => 'Statut mis à jour avec succès.']);
    }

    public function remplaceStatut(Request $request)
    {
        $statut = $request->statut;
        $cell0 = $request->cell0;
        $codecli = $request->codecli;
        $type = $request->type;
        $date = $request->date;
        $index = $request->index;

        





        return response()->json(['message' => 'Statut mis à jour avec succès.']);
    }

    public function refixStatut(Request $request)
    {
        $statut = $request->statut;
        
        return response()->json(['message' => 'Statut mis à jour avec succès.']);
    }

    public function supprimeStatut(Request $request)
    {
        $statut = $request->statut;
        
        return response()->json(['message' => 'Statut mis à jour avec succès.']);
    }
    
    
} 