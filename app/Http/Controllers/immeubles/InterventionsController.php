<?php

namespace App\Http\Controllers\immeubles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Client;
use App\Models\Appartement;

class InterventionsController extends Controller
{
    public function index($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $interventions = Event::where('client_id', $client->id)->get();
        $nbImmAbsent = $this->getAppartementsWithAbsent($codecli);

        return view('immeubles.interventions.index', compact('interventions', 'codecli', 'client', 'nbImmAbsent'));
    }

    private function getAppartementsWithAbsent($codecli)
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

        return $nbImmAbsent;
    }
}
