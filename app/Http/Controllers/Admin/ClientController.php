<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ClientController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $client = Client::where('Codecli', $id)->first();


        return view('admin.client.form', [
            'client' => $client,


        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'Codecli' => 'required',
            'Reftr' => 'required',
            'nom' => 'required',
            'rue' => 'required',
            'codePost' => 'required',
            'codepays' => 'required',
            'tel' => 'required',
            'email' => 'required',
            'gerant' => 'required',
            'nbAppartement' => 'required',
        ]);

        $client = Client::find($request->id);
        $client->Codecli = $request->Codecli;
        $client->Reftr = $request->Reftr;
        $client->nom = $request->nom;
        $client->rue = $request->rue;
        $client->codePost = $request->codePost;
        $client->codepays = $request->codepays;
        $client->tel = $request->tel;
        $client->email = $request->email;
        $client->gerant = $request->gerant;
        $client->rueger = $request->rueger;
        $client->dernierreleve = substr_replace($request->dernierreleve, '', 2, 1);
        $client->codepaysger = $request->codepaysger;
        $client->telger = $request->telger;
        $client->emailger = $request->emailger;
        $client->codepostger = $request->codepostger;
        $client->devise = $request->devise;
        $client->remarque = $request->remarque;
        $client->nbAppartement = $request->nbAppartement;
        $client->decompteUnitaire = $request->decompteUnitaire == null ? 0 : 1;
        $client->save();

        return redirect()->route('immeubles.show', $request->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function geocodeClient(){
        $clients = Client::whereNull('latitude')
            ->whereNull('longitude')
            ->with('codePostelbs')
            ->get();
        foreach ($clients as $client) {
           try {
               $address = $client->rue . ', ' . $client->codepost . ' ' . $client->codePostelbs[0]->Localite . ',' . $client->codePostelbs[0]->CodePays;
           }
           catch (\Exception $e) {
              continue;
           }

            $geocodingData = geocodeAddress($address);
            if (isset($geocodingData['latitude']) && isset($geocodingData['longitude'])) {
                $client->latitude = $geocodingData['latitude'];
                $client->longitude = $geocodingData['longitude'];
                $client->save();
            }
        }
        $message = __('Les Géocordonnées des clients ont été créé avec succès.');
        return redirect()->route('home')->with('success', $message);
    }
}
