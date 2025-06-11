<?php

namespace App\Http\Controllers;

use App\Models\Appareil;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\ErreurAppareil;
use Illuminate\Http\Request;

class AppartementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.typeEvent.test');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.typeEvent.test');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAppartement(Request $request)
    {

       $nbrApp = $request->input('nbr_Appartement');
       $nbr_quot = $request->input('nbr_Quot');
       $NomProp = $request->input('NomProp');
       $NomLoc = $request->input('NomLoc');
       $nbr_radiateur = $request->input('nbr_radiateur');
       $nbr_ComptEC = $request->input('nbr_ComptEC');
       $nbr_ComptEF = $request->input('nbr_ComptEF');
       $nbr_Int = $request->input('nbr_Int');
       $codecli = $request->input('Codecli');

        dd($request);
        return view('admin.typeEvent.test');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit( $Codecli, $RefAppTR )
    {
        $client = Client::where('Codecli', $Codecli)
            ->with([
                'appartements' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'relRadChfs' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'relRadEaus' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'relChaufApps' => fn($query) => $query->where('RefAppTR', $RefAppTR)->latest('DatRel')->first(),
                'relEauApps' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'relChaufs' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'appareils' => fn($query) => $query->where('RefAppTR', $RefAppTR)->with("appareilsErreurs"),
                'relEauFs' => fn($query) => $query->where('RefAppTR', $RefAppTR),
                'relEauCs' => fn($query) => $query->where('RefAppTR', $RefAppTR),
            ])
            ->get();

        return view('admin.property.formProperty.formEdit', ["client" => $client,]);
    }

    public function update(Request $request, $Codecli, $appartement_id)
    {

        // récuperer tous les inputs qui contiennent serialNumber
        $inputs = $request->all();

        $serialNumbers = [];
        foreach ($inputs as $key => $value) {
            if (strpos($key, 'serialNumber') !== false) {
                $serialNumbers[] = $value;
            }
        }



        foreach ($serialNumbers as $serialNumber) {
            if($serialNumber != null ){
                $appareil = Appareil::where('Codecli', $request->input('Codecli'))
                    ->where('RefAppTR', $request->input('RefAppTR'))
                    ->where('numSerie', $serialNumber)
                    ->firstOrFail();

                $appareil->TypeReleve = $request->input('type_'.$serialNumber);
                $appareil->coef = $request->input('coefficient_'.$serialNumber);
                $appareil->sit = $request->input('situation_'.$serialNumber);
                $appareil->numero = $request->input('numero_'.$serialNumber);
                $appareil->materiel_id = $request->input('materiel_'.$serialNumber);
                $appareil->actif = $request->input('actif_'.$serialNumber) == 'on' ? 1 : 0;

                $appareil->save();
            }

        }

        $appartement = Appartement::where('Codecli', $Codecli)
            ->where('RefAppTR', $appartement_id)
            ->firstOrFail();

        $message = __('L\'appartement ::RefAppCli été modifié avec succès.', ['RefAppCli' => $appartement->RefAppCli]);

        return redirect()->route('immeubles.showAppartement', ['Codecli_id' => $Codecli, 'appartement_id' => $appartement_id])->with('success', $message);

    }

    public function DetailUpdate(Request $request, $Codecli, $appartement_id)
    {

        $appartement = Appartement::where('Codecli', $Codecli)
            ->where('RefAppTR', $appartement_id)
            ->firstOrFail();

        $message = __('Les details de l\'appartement ::RefAppCli ont été modifié avec succès.', ['RefAppCli' => $appartement->RefAppCli]);

        return redirect()->route('immeubles.showAppartement', ['Codecli_id' => $Codecli, 'appartement_id' => $appartement_id])->with('success', $message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
