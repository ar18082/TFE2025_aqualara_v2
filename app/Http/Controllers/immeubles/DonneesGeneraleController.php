<?php

namespace App\Http\Controllers\immeubles;

use App\Http\Controllers\Controller;
use App\Models\Clichauf;
use App\Models\CliEau;
use App\Models\Client;
use App\Models\CliGaz;
use App\Models\CliProvision;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DonneesGeneraleController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $month = '01';
        $clients = Client::whereRaw('RIGHT(dernierreleve, 2) = ?', [$month])->with('codePostelbs', 'events')->orderBy('nom')->get();

        return view('documents.listeSDC.listeSdcPdf', compact('clients', 'month'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function provisionUpdate(Request $request, string $codeCli)
    {
    
        // verifier si la provision existe déjà pour le client, la refappTR et la date de décompte
        $provision = Provision::where('Codecli', $codeCli)
            ->where('RefAppTR', $request->RefAppTR)
            ->where('date_decompte', $request->date_decompte)
            ->first();

        if ($provision) {
            $provision->montant = $request->montant;
            $provision->type_repartition = $request->type_repartition;
            $provision->save();

            $message = 'Provision modifiée avec succès';
        }else{
            Provision::create([
                'Codecli' => $codeCli,
                'RefAppTR' => $request->RefAppTR,
                'date_decompte' => $request->date_decompte ? $request->date_decompte : null,
                'montant' => $request->montant,
                'type_repartition' => $request->type_repartition,
            ]);

            $message = 'Provision créée avec succès';
        }

        return redirect()->back()->with('success', $message);
    }

    public function infoAppartUpdate(Request $request, string $codeCli)
    {

       
        $client = Client::where('Codecli', $codeCli)->first();
        
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        // Si c'est une requête GET pour afficher les données
        if ($request->isMethod('get')) {
            return view('immeubles.details.donneesGenerales.InfoAppart', compact('client'));
        }

        // Si c'est une requête POST pour mettre à jour les données
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $appartements = [];

                // Récupérer tous les appartements existants
                $existingAppartements = $client->appartements->keyBy('RefAppTR');

                // Parcourir les données du formulaire
                foreach ($data as $key => $value) {
                    if (strpos($key, 'refAppTR_') !== false) {
                        $index = substr($key, 9); // Enlever 'refAppTR_'
                        $refAppTR = $value;

                        // Créer ou mettre à jour l'appartement
                        $appartement = $existingAppartements->get($refAppTR) ?? new Appartement();
                        $appartement->RefAppTR = $refAppTR;
                        $appartement->RefAppCli = $data['refAppCli_' . $index] ?? '';
                        $appartement->proprietaire = $data['prop_' . $index] ?? '';
                        $appartement->datefin = $data['datefin_' . $index] ? \Carbon\Carbon::createFromFormat('d-m-Y', $data['datefin_' . $index]) : null;
                        $appartement->bloc = $data['bloc_' . $index] ?? '';
                        $appartement->Codecli = $codeCli;
                        $appartement->save();

                        // Mettre à jour les relations
                        if ($appartement->relChaufApps->isNotEmpty()) {
                            $appartement->relChaufApps->first()->update([
                                'AppQuot' => $data['Quot_' . $index] ?? 0,
                                'NbRad' => $data['NbRad_' . $index] ?? 0
                            ]);
                        }

                        if ($appartement->relEauApps->isNotEmpty()) {
                            $appartement->relEauApps->first()->update([
                                'NbCptFroid' => $data['NbCptFroid_' . $index] ?? 0,
                                'NbCptChaud' => $data['NbCptChaud_' . $index] ?? 0
                            ]);
                        }

                        if ($appartement->relGazApps->isNotEmpty()) {
                            $appartement->relGazApps->first()->update([
                                'nbCpt' => $data['Gaz_' . $index] ?? 0
                            ]);
                        }

                        if ($appartement->relElecApps->isNotEmpty()) {
                            $appartement->relElecApps->first()->update([
                                'nbCpt' => $data['Elec_' . $index] ?? 0
                            ]);
                        }
                    }
                }

                return redirect()->back()->with('success', 'Données des appartements mises à jour avec succès');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Erreur lors de la mise à jour des données: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Méthode de requête non supportée');
    }

    public function infoAppartUpdateUploadCsv(Request $request, string $codeCli)
    {
        
        $client = Client::where('Codecli', $codeCli)->first();
        
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        if (!$request->hasFile('csvFile')) {
            return redirect()->back()->with('error', 'Aucun fichier sélectionné');
        }

        $file = $request->file('csvFile');
        
        if ($file->getClientOriginalExtension() !== 'csv') {
            return redirect()->back()->with('error', 'Le fichier doit être au format CSV');
        }

        try {
            // Stocker le fichier
            $path = $file->storeAs('csv', $codeCli . '_' . time() . '.csv');

            // Lire le fichier CSV
            $handle = fopen(storage_path('app/' . $path), 'r');
            if (!$handle) {
                throw new \Exception('Impossible d\'ouvrir le fichier CSV');
            }

            // Lire l'en-tête
            $header = fgetcsv($handle);
            $requiredColumns = ['Codecli', 'RefAppTR', 'RefAppCli', 'proprietaire', 'datefin', 'bloc'];
            
            // Vérifier que toutes les colonnes requises sont présentes
            $missingColumns = array_diff($requiredColumns, $header);
            if (!empty($missingColumns)) {
                fclose($handle);
                throw new \Exception('Colonnes manquantes dans le fichier CSV: ' . implode(', ', $missingColumns));
            }

            // Récupérer les indices des colonnes
            $columnIndices = array_flip($header);

            // Récupérer les appartements existants
            $existingAppartements = $client->appartements->keyBy('RefAppTR');

            // Lire les données
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Vérifier que c'est bien le bon client
                if ($data['Codecli'] !== $codeCli) {
                    continue;
                }

                // Créer ou mettre à jour l'appartement
                $appartement = $existingAppartements->get($data['RefAppTR']) ?? new Appartement();
                $appartement->RefAppTR = $data['RefAppTR'];
                $appartement->RefAppCli = $data['RefAppCli'];
                $appartement->proprietaire = $data['proprietaire'];
                $appartement->datefin = $data['datefin'] ? \Carbon\Carbon::createFromFormat('d-m-Y', $data['datefin']) : null;
                $appartement->bloc = $data['bloc'];
                $appartement->Codecli = $codeCli;
                $appartement->save();
            }

            fclose($handle);
            return redirect()->back()->with('success', 'Fichier CSV traité avec succès');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du traitement du fichier: ' . $e->getMessage());
        }
    }

    public function donneeGeneraleUpdate(Request $request, string $codeCli, string $type)
    {
       
       
        $client = Client::where('Codecli', $codeCli)->first();

        if ($client) {
            $clientId = $client->id;
        } else {
            $clientId = null;
        }

        switch ($type) {
            case 'chauff':
                
                Clichauf::updateOrCreate(
                    ['id' => $request->id],
                    ['Codecli' => $codeCli],
                    [
                        'client_id' => $clientId,
                        'Codecli' => $codeCli,
                        'PctPrive' => $request->PctPrive,
                        'PctCom' => $request->PctCom,
                        'Consom' => $request->Consom,
                        'ConsPrive' => $request->ConsPrive,
                        'Quotite' => $request->Quotite,
                        'TypCal' => $request->TypCal,
                        'TypRlv' => $request->TypRlv,
                        'FraisTR' => $request->FraisTR
                    ],
                );

                $message = true;
                break;
            case 'eau':

                CliEau::updateOrCreate(
                    ['id' => $request->id],
                    ['Codecli' => $codeCli],
                    [
                        'client_id' => $clientId,
                        'Codecli' => $codeCli,
                        'PrxFroid' => $request->PrxFroid,
                        'PrxChaud' => $request->PrxChaud,
                        'TypCpt' => $request->TypCpt,
                        'FraisTR' => $request->FraisTR,
                        'FraisAnn' => $request->FraisAnn,
                        'Consom' => $request->Consom,
                        'Unite' => $request->Unite,
                        'SupChaud' => $request->SupChaud,
                        'Periode' => $request->Periode,
                        'UnitAnn' => $request->UnitAnn,
                        'TypCal' => $request->TypCal,
                        'ChaudChf' => $request->ChaudChf,
                        'EauSol' => $request->EauSol,
                        'TypRlv' => $request->TypRlv,


                    ],
                );

                $message = true;
                break;
            case 'Gaz':
                CliGaz::updateOrCreate(
                    ['id' => $request->id],
                    ['Codecli' => $codeCli],
                    [
                        'client_id' => $clientId,
                        'Codecli' => $codeCli,
                        'prix' => $request->PrxGaz,
                        'TypCpt' => $request->TypCpt,
                        'FraisTR' => $request->FraisTR,
                        'FraisAnn' => $request->FraisAnn,
                        'Consom' => $request->Consom,
                        'Periode' => $request->Periode,
                        'UnitAnn' => $request->UnitAnn,
                        'TypCal' => $request->TypCal,
                    ],
                );

                $message = true;
                break;
            case 'Elec':

                CliGaz::updateOrCreate(
                    ['id' => $request->id],
                    ['Codecli' => $codeCli],
                    [
                        'client_id' => $clientId,
                        'Codecli' => $codeCli,
                        'prix' => $request->PrxGaz,
                        'TypCpt' => $request->TypCpt,
                        'FraisTR' => $request->FraisTR,
                        'FraisAnn' => $request->FraisAnn,
                        'Consom' => $request->Consom,
                        'Periode' => $request->Periode,
                        'UnitAnn' => $request->UnitAnn,
                        'TypCal' => $request->TypCal,
                    ],
                );

                $message = false;
                break;
            default:
                $message = false;
                break;
        }

        if($message == false)
            return redirect()->back()->with('error', 'Erreur lors de la modification des données générales');
        else {
            return redirect()->back()->with('success', 'Données générales modifiées avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
