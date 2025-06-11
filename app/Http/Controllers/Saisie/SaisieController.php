<?php

namespace App\Http\Controllers\Saisie;

use App\Http\Controllers\Controller;

// Models
use App\Models\Appartement;

//chauffage
use App\Models\RelChauf;
use App\Models\RelChaufApp;
use App\Models\RelRadChf;

//eau
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelRadEau;
use App\Models\RelEauApp;

//elec
use App\Models\RelElec;
use App\Models\RelElecApp;

//gaz
use App\Models\RelGaz;
use App\Models\RelGazApp;

//date provisoire

use App\Helpers\AppartementHelper;
use App\Models\Client;
use App\Models\DecEntete;
use App\Models\DecDateProvisoire;


// Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaisieController extends Controller
{

    private function getinfoSaisie($codecli)
    {
        $client = Client::where('Codecli', $codecli)
            ->with('clichaufs')
            ->with('cliElecs')
            ->with('cliGazs')
            ->with('cliEaus')
            ->first();
       
        $decomptes =  DecDateProvisoire::where('Codecli', $codecli)
                ->select('date_fin as date')
                ->orderBy('date_fin', 'desc')
                ->union(
                    DecEntete::where('Codecli', $codecli)
                    ->select('finPer as date')
                    ->orderBy('finPer', 'desc')
                )
                ->get();

        
        
        return [
            'client' => $client,
            'decomptes' => $decomptes
        ];
    }
    public function index($codecli)
    {
        $infoSaisie = $this->getinfoSaisie($codecli);
        $client = $infoSaisie['client'];
        $decomptes = $infoSaisie['decomptes'];
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['decomptes'] = $decomptes;
        $check = false;
        $data['parametres'] = RelChaufApp::where('Codecli', $codecli)
            ->select('*')
            ->orderBy('RefAppTR')
            ->orderBy('DatRel', 'desc')
            ->get()
            ->unique('RefAppTR');
       
        if($client->clichaufs->count() > 0) {
            if($client->clichaufs[0]->TypRlv == 'VISU') {
               $releves = RelChauf::where('Codecli', $codecli)
                ->select('*')
                ->orderBy('RefAppTR')
                ->orderBy('DatRel', 'desc')
                ->get()
                ->unique('NumRad');
            } else {
                $releves = RelRadChf::where('Codecli', $codecli)
                ->select('*')
                ->orderBy('RefAppTR')
                ->orderBy('DatRel', 'desc')
                ->get()
                ->unique('NumCal');
            }
            
            $data['releves'] = $releves;
            $data['content'] = 'immeubles.saisies.components.saisieChauffage';
           
        }else{
            $check = true;
            $data['content'] = 'immeubles.saisies.components.noSaisie';
        }
    
      
       
        $data['check'] = $check;
       
        
        return view('immeubles.saisies.index', $data);
    }

    public function saisieEau($codecli)
    {
        $infoSaisie = $this->getinfoSaisie($codecli);
        $client = $infoSaisie['client'];
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $decomptes = $infoSaisie['decomptes'];
        $data['decomptes'] = $decomptes;
        $check = false;
        $parametres = RelEauApp::where('Codecli', $codecli)
            ->select('*')
            ->orderBy('RefAppTR')
            ->orderBy('DatRel', 'desc')
            ->get()
            ->unique('RefAppTR');

           
    
        
        if($client->cliEaus->count() > 0) {
            if($client->cliEaus[0]->TypRlv == 'VISU') {
               $relEauC = RelEauC::where('Codecli', $codecli)
                ->select('*')
                ->orderBy('RefAppTR')
                ->orderBy('DatRel', 'desc')
                ->get()
                ->unique('NumCpt');

                $relEauF = RelEauF::where('Codecli', $codecli)
                ->select('*')
                ->orderBy('RefAppTR')
                ->orderBy('DatRel', 'desc')
                ->get()
                ->unique('NumCpt');
                

            } else {
                $relEauC = RelRadEau::where('Codecli', $codecli)
                ->select('*')
                ->orderBy('RefAppTR')
                ->orderBy('DatRel', 'desc')
                ->get()
                ->unique('NumCpt');

        
            }

          
          
            $data['parametres'] = $parametres;
            $data['relEauCs'] = $relEauC;
            $data['relEauFs'] = $relEauF;
            $data['content'] = 'immeubles.saisies.components.saisieEau';
        }else{
            $check = true;
            $data['content'] = 'immeubles.saisies.components.noSaisie';
        }

       
        $data['check'] = $check;
        return view('immeubles.saisies.index', $data);
    }

    public function saisieGaz($codecli)
    {
        $infoSaisie = $this->getinfoSaisie($codecli);
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $infoSaisie['client'];
        $client = $infoSaisie['client'];
        $check = false;
        if($client->cliGazs->count() > 0) {
            $data['decomptes'] = $infoSaisie['decomptes'];
            $data['content'] = 'immeubles.saisies.components.saisieGaz';
            $data['check'] = false;
        }else{
            $check = true;
            $data['content'] = 'immeubles.saisies.components.noSaisie';
        }
        $data['check'] = $check;
        return view('immeubles.saisies.index', $data);
    }

    public function saisieElec($codecli)
    {
        $infoSaisie = $this->getinfoSaisie($codecli);
        $client = $infoSaisie['client'];
        $check = false;
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        
        $check = false;
        if($client->cliElecs->count() > 0) {
            $data['decomptes'] = $infoSaisie['decomptes'];
            $data['content'] = 'immeubles.saisies.components.saisieElec';
            $data['check'] = false;
        }else{
            $check = true;
            $data['content'] = 'immeubles.saisies.components.noSaisie';
        }
        $data['check'] = $check;
        return view('immeubles.saisies.index', $data);
    }

    public function saveSaisieRel(Request $request)
    {
        try {
            DB::beginTransaction();

            $codeCli = $request->input('codeCli');
            $refAppTR = $request->input('refAppTR');
            $dateReleve = $request->input('dateReleve');
            $tableData = $request->input('tableData');

            foreach ($tableData as $data) {
                // Créer ou mettre à jour le relevé
                RelChauf::updateOrCreate(
                    [
                        'Codecli' => $codeCli,
                        'RefAppTR' => $refAppTR,
                        'NumCal' => $data['numCal'],
                        'DatRel' => $dateReleve
                    ],
                    [
                        'NumRad' => $data['numRad'],
                        'TypCal' => $data['typCal'],
                        'Statut' => $data['statut'],
                        'Sit' => $data['situation'],
                        'Coef' => $data['coefficient'],
                        'AncIdx' => $data['ancienIndex'],
                        'NvIdx' => $data['nouvelIndex'],
                        'Diff' => $data['difference']
                    ]
                );
            }

            // Mettre à jour les données de l'appartement si nécessaire
            RelChaufApp::updateOrCreate(
                [
                    'Codecli' => $codeCli,
                    'RefAppTR' => $refAppTR,
                    'DatRel' => $dateReleve
                ],
                [
                    'NbRad' => count($tableData)
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Données sauvegardées avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getNextRefAppTR(Request $request)
    {
        try {
            $codeCli = $request->input('codeCli');
            $currentRefAppTR = $request->input('currentRefAppTR');

            // Récupérer le prochain appartement
            $nextAppartement = Appartement::where('Codecli', $codeCli)
                ->where('RefAppTR', '>', $currentRefAppTR)
                ->orderBy('RefAppTR', 'asc')
                ->first();

            if ($nextAppartement) {
                return response()->json([
                    'success' => true,
                    'nextRefAppTR' => $nextAppartement->RefAppTR,
                    'message' => 'Prochain appartement trouvé'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun autre appartement disponible'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche du prochain appartement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSaisies(Request $request)
    {

       
        $codecli = $request->input('codecli');
        $type = $request->input('type');
        $dateRlv = $request->input('dateRlv');
        $refAppTR = $request->input('refAppTR');
        // get all data from the $request without the codecli, type, dateRlv, refAppTR
       $datas = $request->input('formData');

       try {
            switch($type) {
                case 'chauffage':
                    foreach($datas as $data) {
                        $relChauf = new RelChauf();
                        $relChauf->Codecli = $codecli;
                        $relChauf->RefAppTR = $refAppTR;
                        $relChauf->DatRel = $dateRlv;
                        $relChauf->NumRad = $data[0];
                        $relChauf->NumCal = $data[1];
                        $relChauf->TypCal = $data[2];
                        $relChauf->Statut = $data[3];
                        $relChauf->Sit = $data[4];
                        $relChauf->Coef = $data[5];
                        $relChauf->AncIdx = $data[6];
                        $relChauf->NvIdx = $data[7];
                        
                        // $relChauf->save();
                    }
                    break;
                case 'eau':
                    foreach($datas as $data) {
                        if($data[0] == 'chaude') {
                            $relEau = new RelEauC();
                        }else{
                            $relEau = new RelEauF();
                        }
                        $relEau->Codecli = $codecli;
                        $relEau->RefAppTR = $refAppTR;
                        $relEau->DatRel = $dateRlv;
                        $relEau->NoCpt = $data[1];
                        $relEau->NumCpt = $data[2];
                        $relEau->Statut = $data[3];
                        $relEau->Sit = $data[4];
                        $relEau->AncIdx = $data[5];
                        $relEau->NvIdx = $data[6];
                        $relEau->Diff = $data[7];
                        // $relEau->save();
                    }
                    break;
                case 'gaz':
                    foreach($datas as $data) {
                        $relGaz = new RelGaz();
                        $relGaz->Codecli = $codecli;
                        $relGaz->RefAppTR = $refAppTR;
                    }
                    break;
                case 'elec':
                    foreach($datas as $data) {
                        $relElec = new RelElec();
                        $relElec->Codecli = $codecli;
                        $relElec->RefAppTR = $refAppTR;
                    }
                    break;
            }
            return response()->json([
                'success' => true,
                'message' => 'Saisies sauvegardées avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde des saisies: ' . $e->getMessage()
            ], 500);
        }

        
    }

    public function getParametres(Request $request)
    {
        
        $codecli = $request->input('codecli');
        $type = $request->input('type');
        $dateRlv = $request->input('dateRlv');
        $refAppTR = $request->input('refAppTR');
        $datas = $request->input('params');
        


       
        try {
            switch ($type) {
                case 'chauffage':
                    // check if the parametres exist in the database if not create it else update it
                $parametres = RelChaufApp::where('Codecli', $codecli)
                    ->where('RefAppTR', $refAppTR)
                    ->where('DatRel', $dateRlv)
                    ->first();

                if(!$parametres) {
                    $parametres = new RelChaufApp();
                    $parametres->Codecli = $codecli;
                    $parametres->RefAppTR = $refAppTR;
                    $parametres->DatRel = $dateRlv;
                    $parametres->NbFraisTR = $datas['nbFraisTR'];
                    $parametres->NbRad = $datas['nbRad'];
                    $parametres->FraisDiv = $datas['fraisDiv'];
                    $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                    $parametres->AppQuot = $datas['appQuot'];
                  

                }else{
                    $parametres->NbFraisTR = $datas['nbFraisTR'];
                    $parametres->NbRad = $datas['nbRad'];
                    $parametres->FraisDiv = $datas['fraisDiv'];
                    $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                    $parametres->AppQuot = $datas['appQuot'];
                   
                }
                $parametres->save();

                break;
                case 'eau':
                  
                    // différencier eau chaude et eau froide 
                    $parametres = RelEauApp::where('Codecli', $codecli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', $dateRlv)
                        ->first();

                    if(!$parametres) {
                        $parametres = new RelEauApp();
                        $parametres->Codecli = $codecli;
                        $parametres->RefAppTR = $refAppTR;
                        $parametres->DatRel = $dateRlv;
                        $parametres->NbCptEauFroid = $datas['nbCptEauFroid'];
                        $parametres->NbCptEauChaud = $datas['nbCptEauChaud'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTRChaud'];
                        $parametres->NbFraisTRF = $datas['nbFraisTR'];

                        
                        
                    }else{
                        $parametres->NbCptEauFroid = $datas['nbCptEauFroid'];
                        $parametres->NbCptEauChaud = $datas['nbCptEauChaud'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTRChaud'];
                        $parametres->NbFraisTRF = $datas['nbFraisTR'];

                    }

                    $parametres->save();

                    break;
                case 'gaz':
                    $parametres = RelGazApp::where('Codecli', $codecli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', $dateRlv)
                        ->first();

                    if(!$parametres) {
                        $parametres = new RelGazApp();
                        $parametres->Codecli = $codecli;
                        $parametres->RefAppTR = $refAppTR;
                        $parametres->DatRel = $dateRlv;
                        $parametres->NbCpt = $datas['nbCpt'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTR'];
                        
                    }else{
                        $parametres->NbCpt = $datas['nbCpt'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTR'];
                        
                    }

                    $parametres->save();

                    break;
                case 'elec':
                    $parametres = RelElecApp::where('Codecli', $codecli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', $dateRlv)
                        ->first();

                    if(!$parametres) {
                        $parametres = new RelElecApp();
                        $parametres->Codecli = $codecli;
                        $parametres->RefAppTR = $refAppTR;
                        $parametres->DatRel = $dateRlv;
                        $parametres->NbCpt = $datas['nbCpt'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTR'];
                        
                    }else{
                        $parametres->NbCpt = $datas['nbCpt'];
                        $parametres->FraisDiv = $datas['fraisDiv'];
                        $parametres->PctFraisAnn = $datas['pctFraisAnn'];
                        $parametres->AppQuot = $datas['appQuot'];
                        $parametres->NbFraisTR = $datas['nbFraisTR'];
                        
                    }

                    $parametres->save();
                    
                    break;
            }
            return response()->json([
                'success' => true,
                'message' => 'Parametres sauvegardés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde des parametres: ' . $e->getMessage()
            ], 500);
        }
        
    }

    public function getDateReleve(Request $request, $codecli)
    {
        try {
            $date = $request->input('date');
            
            // Validate date format
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format de date invalide. Utilisez le format YYYY-MM-DD'
                ], 400);
            }

            // Check if date already exists
            $dateDecompte = DecEntete::where('Codecli', $codecli)
                ->where('finPer', $date)
                ->first();

            if($dateDecompte) { 
                return response()->json([
                    'success' => true,
                    'message' => 'Date de décompte existe déjà'
                ]);
            }

            // Get the last date record
            $lastDate = DecEntete::where('Codecli', $codecli)
                ->orderBy('finPer', 'desc')
                ->first();

            // Calculate start date
            $debPer = $lastDate ? date('Y-m-d', strtotime($lastDate->finPer . ' + 1 day')) : $date;

            // Create new record
            $dateDecompte = new DecDateProvisoire();
            $dateDecompte->Codecli = $codecli;
            $dateDecompte->date_debut = $debPer;
            $dateDecompte->date_fin = $date;
            $dateDecompte->save();

            return response()->json([
                'success' => true,
                'message' => 'Date de décompte créée avec succès'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur dans getDateReleve: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la date de décompte: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeDateReleve(Request $request, $codecli)
    {
        $date = $request->input('date');
        try {
            $dateDecompte = DecEntete::where('Codecli', $codecli)
                ->where('finPer', $date)
                ->first();

            if($dateDecompte) {
                $dateDecompte->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Date de décompte supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la date de décompte: ' . $e->getMessage()
            ], 500);
        }
    }
} 