<?php

namespace App\Http\Controllers\immeubles;
use App\Models\Client;
use App\Models\Appartement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppartementsController extends Controller
{
    public function getAppartements(Request $request)
    {
        $codecli = $request->codecli;
       
        // $client = Client::where('Codecli', $codecli)->first();
        // $appartements = Appartement::where('Codecli', $codecli)->get();

        $client = Client::where('Codecli', $codecli)
            ->with(['codePostelbs' => function($query) {
                $query->select('Localite');
            }])
            ->with('gerantImms.contacts')
            ->with('clichaufs')
            ->with('cliEaus')
            ->with('cliElecs')
            ->with('cliGazs')
            ->with('cliProvisions')
            ->firstOrFail();

            $appartements = Appartement::where('codeCli', $codecli)
                ->with(['relApps' => function($query) use ($codecli) {
                    $query->select('proprioCd', 'locatCd', 'refAppTR')
                        ->where('Codecli', $codecli)
                        ->latest('datRel');
                }])
                ->with(['relChaufApps' => function($query) use ($codecli) {
                    $query->select('NbRad', 'RefAppTR')
                        ->where('Codecli', $codecli)
                        ->latest('DatRel');
                }])
                ->with(['relEauApps' => function($query) use ($codecli) {
                    $query->select('NbCptFroid', 'NbCptChaud', 'RefAppTR')
                        ->where('Codecli', $codecli)
                        ->latest('DatRel');
                }])
                ->with(['relElecApps' => function($query) use ($codecli) {
                    $query->select('NbCpt', 'RefAppTR')
                        ->where('Codecli', $codecli)
                        ->latest('DatRel');
                }])
                ->with(['relGazApps' => function($query) use ($codecli) {
                    $query->select('nbCpt', 'RefAppTR')
                        ->where('Codecli', $codecli)
                        ->latest('DatRel');
                }])
                ->get();
    

                dd($appartements);

        return view('immeubles.appartements.index', compact('appartements', 'client', 'codecli'))  ;
    }
}
