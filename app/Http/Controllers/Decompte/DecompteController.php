<?php

namespace App\Http\Controllers\Decompte;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\RelElec;
use App\Models\RelGaz;
use App\Models\RelChauf;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelElecApp;
use App\Models\RelGazApp;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use App\Models\Provision;
use App\Models\DecEntete;
use App\Models\CliChauf;
use App\Models\CliEau;
use App\Models\CliElec;
use App\Models\CliGaz;
use App\Models\DecDateProvisoire;
use App\Helpers\AppartementHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Webmozart\Assert\Tests\StaticAnalysis\integer;

class DecompteController extends  Controller    
{
    public function index($codecli)
    {

        $client = Client::where('Codecli', $codecli)->first();
       
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
       
        $data['content'] = 'immeubles.decomptes.components.genererDecompte';
        return view('immeubles.decomptes.index', $data);
    }

    public function preparation($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $appartements = Appartement::where('Codecli', $codecli)->get();
        $decompteProvisoire = DecDateProvisoire::where('Codecli', $codecli)
                    ->orderBy('date_fin', 'desc')
                    ->first();
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['appartements'] = $appartements;
        $data['decompteProvisoire'] = $decompteProvisoire;

        
       
      
        $data['content'] = 'immeubles.decomptes.components.preparationDecompte';
       
       
        
        return view('immeubles.decomptes.index', $data);
    }

    public function cloture($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $decomptes = DecEntete::where('statut', '!=', 'CLOTURE')
                    ->with('client')
                    ->orderBy('debPer', 'desc')
                    ->paginate(10);
        $data['client'] = $client;
        $data['decomptes'] = $decomptes;
        $data['content'] = 'immeubles.decomptes.components.clotureDecompte';
        return view('immeubles.decomptes.index', $data);
    }

    public function editions($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.decomptes.components.editionsDecompte';
        return view('immeubles.decomptes.index', $data);
    }

    public function storePreparation(Request $request, $codecli)
    {
       
        // recuperer les datas du formulaire 
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;
        $client = Client::where('Codecli', $codecli)->first();
        $typeCalcul = $request->typeCalcul;
        $optionImpression = $request->optionImpression;

       
        // verifier si la date de debut est inferieur a la date de fin 
        if ($dateDebut > $dateFin) {    
            return redirect()->route('immeubles.decompte.preparation', $codecli)->with('error', 'La date de début ne peut pas être supérieure à la date de fin');
        }

        

        switch ($typeCalcul) {
            case 'complet': // créer un décompte individuel pour chaque appartement  + tableau récapitulatif  en 1 seul pdf 
                // récupérer tous les appartements 
               

                break;
            case 'individuel': // créer un décompte individuel pour chaque appartement selectionné  en deux pdf 
                // récupérer les appartements sélectionné 
               
                break;
            case 'gerance': // créer un décompte récapitulatif  en un seul pdf 
                // récupérer le récap 
                
                break;
        }
        
          
            // vérifier si il y a des erreurs
            $cliChaufs = CliChauf::where('Codecli', $codecli)
            ->where('updated_at', 'like', '%'. $dateFin . '%')
            ->get();
            
            $cliEaux = CliEau::where('Codecli', $codecli)
            ->where('updated_at', 'like', '%'. $dateFin . '%')
            ->get();
            $cliElecs = CliElec::where('Codecli', $codecli)
            ->where('updated_at', 'like', '%'. $dateFin . '%')
            ->get();
            $cliGazs = CliGaz::where('Codecli', $codecli)
            ->where('updated_at', 'like', '%'. $dateFin . '%')
            ->get();
    
            $relChaufsApp = RelChaufApp::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
            $relEauxApp = RelEauApp::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
            $relElecsApp = RelElecApp::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
            $relGazsApp = RelGazApp::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
    
            $relChaufs = RelChauf::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
            // $relEaux = RelEau::where('Codecli', $codecli)
            // ->where('DatRel',  $dateFin )
            // ->get();
            $relElecs = RelElec::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
            $relGazs = RelGaz::where('Codecli', $codecli)
            ->where('DatRel',  $dateFin )
            ->get();
    
            /*
                    
            si index inférieur ancienne index en calo ou en eau (direct dans la saisie sauf cpt eau envers)  si radio pas d'index -0.1 
            n° appartement + n) compteur concerné
    
    
            différence en nombre saisie eau et chauffage uniquement quand il y a de l'eau  par appartement  (analyser appartement par appartement) 
    
            nbr quotité total dans détail == quotité totale de chaque appartement 
            idem unite frais annexe 
    
                    
    
            */
             // il faut vérifier les données sont correctes et si elles existent 
             if($cliChaufs->count() > 0){
                dd($cliChaufs);
                // il faut vérifier si les données sont correctes 
                // si elles sont incorrect il faut renvoyer vers listeErreurs 
                // si non renvoyer vers route clorureDecompte 
             }
             // si elles sont incorrect il faut renvoyer vers listeErreurs 
             // si non renvoyer vers route clorureDecompte 
              
             return view('decompte.word.templates.decompte');
  
       
        // verifier le type de calcul
        

         
    }

    public function storeCloture(Request $request, $codecli)
    {
        dd($request->all());

        // recuperer les données et envoyer vers clotureDecompte 

        return redirect()->route('immeubles.decompte.listeDecompte', $codecli);
    }

    public function storeEditions(Request $request, $codecli)       
    {
        dd($request->all());

    }

    public function listeErreurs(Request $request, $codecli)
    {
        dd($request->all());
        // recuperer les données et return vue  listeErreurs 

        return view('immeubles.decomptes.listeErreurs', $data);
    }

   
}


