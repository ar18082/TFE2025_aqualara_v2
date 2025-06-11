<?php

namespace App\Http\Controllers\immeubles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileStorageFormRequest;
use App\Models\Absent;
use App\Models\Appareil;
use App\Models\AppareilsErreur;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\CodePostelb;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Event;
use App\Models\FileStorage;
use App\Models\Materiel;
use App\Models\NotesAppartement;
use App\Models\relApp;
use App\Models\RelChauf;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelElecApp;
use App\Models\RelGaz;
use App\Models\RelGazApp;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use App\Models\typeErreur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Webmozart\Assert\Tests\StaticAnalysis\false;
use function Webmozart\Assert\Tests\StaticAnalysis\isArray;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class ImmeublesController extends Controller
{
    private function searchClient($request){

        if($request->all()){

           //$codeimmeuble = intval($request->input('codeimmeuble', ''));
            $nom = $request->input('nom', '');
            $rue = $request->input('rue', '');
            $cp_localite = $request->input('cp_localite', '');
            $chauftype = $request->input('chauftype', '');
            $eautype = $request->input('eautype', '');

            if ( $nom == '' && $rue == '' && $cp_localite == '' && $chauftype == '' && $eautype == '') {
                $clients = Client::with('gerantImms')->with('codePostelbs')->whereHas('appartements')->orderBy('Codecli', 'asc')->paginate(25);
            }else {

                $clients = Client::with('gerantImms')->with('codePostelbs')->whereHas('appartements')->orderBy('Codecli', 'asc');



                if ($nom != '') {

                    $clients = $clients->where('id', $nom);
                }

                if ($rue != '') {

                    $clients = $clients->where('id', $rue);

                }

                if ($cp_localite != '') {
                    $clients = $clients->whereHas('codePostelbs', function ($query) use ($cp_localite) {
                        $query->where('code_postelb_id', $cp_localite);
                    });
                }

                if ($chauftype != '') {
                    $clients = $clients->whereHas('clichaufs', function ($subQuery) use ($chauftype) {
                        $subQuery->where('TypRlv', '=', $chauftype);
                    });
                }

                if ($eautype != '') {
                    $clients = $clients->whereHas('cliEaus', function ($subQuery) use ($eautype) {
                        $subQuery->where('TypRlv', '=', $eautype);
                    });
                }

                $clients = $clients->paginate(25);


            }
        }else{
            $clients = Client::with('gerantImms')->with('codePostelbs')->whereHas('appartements')->orderBy('Codecli', 'asc')->paginate(25);


        }

        return $clients;
    }

    public function index(Request $request)
    {

        
//
        if (Auth::check() && Auth::user()->role === 'admin') {
            $clients = $this->searchClient($request);
           


        }else {

            $technicianId = Auth::user()->technicien_id;
            $today = now()->format('Y-m-d');
            $days = now()->addDays(7)->format('Y-m-d');

            $clients = Client::whereHas('events', function ($query) use ($today, $technicianId, $days) {
                $query->whereDate('start', '>=', $today)
                    ->whereDate('start', '<=', $days)
                    ->where('valide', false)
                    ->whereHas('techniciens', function ($query) use ($technicianId) {
                        $query->where('techniciens.id', $technicianId);
                    });

            })
                ->with('gerantImms')
                ->with('codePostelbs')
                //->whereHas('appartements')
                ->orderBy('Codecli', 'asc')
                ->paginate(25);


        }

        return view('immeubles.index', [
            'clients' => $clients,
        ]);

    }

    public function searchClientByNameOrCodecli(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;


            if (is_numeric($search)) {
                $data = Client::where('Codecli', 'LIKE', "%".intval($search)."%")
                    ->orderBy('Codecli', 'asc')
                    ->get();
            } else {
                // Si la valeur n'est pas numérique, recherche par nom
                $data = Client::where('nom', 'LIKE', "%$search%")->get();
            }

        }



        return response()->json($data);

    }

    public function searchClientByStreet(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;


            if(strstr($search,' ')){
                $searchArray = array();
                foreach(explode(' ',$search) as $word){
                    $searchArray[] = ['rue', 'LIKE', '%'.$word.'%'];
                }

                $data = Client::where($searchArray)->get();
            }
            else{

                $data = Client::where('rue', 'LIKE', "%$search%")->get();
            }




        }



        return response()->json($data);

    }

    public function searchClientByCPOrLocalite(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;


            if (is_numeric($search)) {
                // Si la valeur est numérique, recherche par Codecli
                $data = CodePostelb::where('codePost', 'LIKE', "%$search%")->get();
            } else {
                // Si la valeur n'est pas numérique, recherche par nom
                $data = CodePostelb::where('Localite', 'LIKE', "%$search%")->get();
            }



        }
    
        return response()->json($data);

    }


    public function showReleve($Codecli_id, $immeuble_id, $type, $ref)
    {
        //récupération des datas clients
        $client = Client::with('gerantImms', 'relApps')
            ->with('codePostelbs')
            ->with('clichaufs')
            ->with('cliEaus')
            ->with('relChaufApps')
            ->with('relEauApps')
            ->where('Codecli', $Codecli_id)
            ->firstOrFail();

        $relApps = relApp::where('Codecli', $Codecli_id)->where('RefAppTr', $immeuble_id)->get();

        // récupération absences pour le header
        $appartements_for_count = Appartement::with('Absent', 'notesAppartements')
            ->where('Codecli', $Codecli_id)->get();

        $nbImmAbsent = 0;

        foreach ($appartements_for_count as $appartement) {
            if ($appartement->Absent->count() > 0) {
                if ($appartement->Absent->first()->is_absent) {
                    $nbImmAbsent++;
                }
            }
        }


        $appareil = Appareil::where('codeCli', $Codecli_id)->where('refAppTR', $immeuble_id)->where('numSerie', $ref)->first();
        if($appareil == null){
            $ref = '0'.$ref;
            $appareil = Appareil::where('codeCli', $Codecli_id)->where('refAppTR', $immeuble_id)->where('numSerie', $ref)->first();

        }
        if($appareil == null){
            dd('Appareil non trouvé');
        }

        $erreur = AppareilsErreur::where('appareil_id', $appareil->id)->with("typeErreur")->first();



        switch ($type) {
            case 'VISU_EAU_C':
                $rel_Filtered = RelEauC::where('NumCpt', 'like', $ref)
                    ->where('Codecli', $Codecli_id)
                    ->where('RefAppTR', $immeuble_id)
                    ->orderBy('DatRel', 'desc')
                    //->take(24)
                    ->get();
                break;
            case 'VISU_EAU_F':
                $rel_Filtered = RelEauF::where('NumCpt', 'like', $ref)
                    ->where('Codecli', $Codecli_id)
                    ->where('RefAppTR', $immeuble_id)
                    ->orderBy('DatRel', 'desc')
                    //->take(24)
                    ->get();
                break;
            case 'RADIO_EAU' :
                $rel_Filtered = relRadEau::where('Numcal', 'like', $ref)
                    ->where('Codecli', $Codecli_id)
                    ->where('RefAppTR', $immeuble_id)
                    ->orderBy('DatRel', 'desc')
                    //->take(24)
                    ->get();
                break;
            case 'VISU_CH':

                $rel_Filtered = RelChauf::where('Codecli', $Codecli_id)
                    ->where('RefAppTR', $immeuble_id)
                    ->where('NumCal', 'like', $ref)
                   //->take(24)
                    ->get();


                break;
            case 'RADIO_CH':
                $rel_Filtered = RelRadChf::where('Numcal', 'like', '%'.$ref.'%')
                    ->where('Codecli', $Codecli_id)
                    ->where('RefAppTR', $immeuble_id)
                    ->orderBy('DatRel', 'desc')
                    // ->take(24)
                    ->get();

                break;

        }


        $images = FileStorage::where('codeCli', $Codecli_id)
            ->where('appareil_id', $appareil->id)
            ->with('appareil', 'appartement')
            ->get();





        return view('immeubles.showReleve', [
            'Codecli' => $Codecli_id,
            'appartement' => $appartement,
            'client' => $client,
            'nbImmAbsent' => $nbImmAbsent,
            'relApps' => $relApps,
            'immeuble_id' => $immeuble_id,
            'type' => $type,
            'rel_Filtered' => $rel_Filtered,
            'appareil' => $appareil,
            'erreur' => $erreur,
            'images' => $images

        ]);
    }

    public function showAppartement($Codecli_id, $immeuble_id)
    {
        $client = Client::with([
            'gerantImms', 'relApps', 'codePostelbs', 'clichaufs', 'cliEaus', 'relChaufApps', 'relEauApps'
        ])->where('Codecli', $Codecli_id)->firstOrFail();


        $relApps = relApp::where('Codecli', $Codecli_id)->where('RefAppTR', $immeuble_id)->get();

        $appartement = Appartement::with('notesAppartements')
            ->where('Codecli', $Codecli_id)->where('RefAppTR', $immeuble_id)->firstOrFail();

        $chauType = $client->clichaufs->first();
        $chaufsType = isset($chauType->TypRlv) ? $chauType->TypRlv : null;
        $eauType = $client->cliEaus->first()->TypRlv ?? null;

        $rel_Chaufs = $this->getRelChaufs($Codecli_id, $immeuble_id, $chaufsType );
        $rel_eau = $this->getRelEau($Codecli_id, $immeuble_id);
        $releves = [];

        foreach ($rel_Chaufs as $relChauf) {
            foreach ($relChauf as $rel) {
                array_push($releves, $rel);
            }
        }

        foreach ($rel_eau as $relEau) {
            foreach ($relEau as $rel) {
                array_push($releves, $rel);
            }
        }

        $appareilsErreurs = AppareilsErreur::where('codeCli', $Codecli_id)
            ->where('refAppTR', $immeuble_id)
            ->get();

        //dd(gettype($appareilsErreurs));

        $materiels = Materiel::all();

         $notes = $this->getNotes($appartement);
         $typeErreurs = typeErreur::all();
         $nbImmAbsent = ''; //$this->getNbImmAbsent($Codecli_id);
//
        $files = FileStorage::select('*')->where('codeCli', $Codecli_id)->with('appareil.materiel', 'appartement')->orderBY('created_at', 'desc')->get();


        $dismissed = false;
        $type = '';

//        dd($releves);


        return view('immeubles.showAppartement', compact(
            'Codecli_id', 'appartement', 'client', 'relApps', 'releves','appareilsErreurs',
             'notes', 'nbImmAbsent', 'files', 'immeuble_id', 'typeErreurs', 'chaufsType', 'eauType', 'dismissed', 'type', 'materiels',
        ));
    }

    private function getRelChaufs($Codecli_id, $immeuble_id, $chaufsType)
    {
        $relChaufs = [];


        if ($chaufsType == 'VISU') {
            $results = RelChauf::select('rel_chaufs.*')
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumRad
                      FROM rel_chaufs
                      WHERE Codecli = ' . $Codecli_id . ' AND RefAppTR = ' . $immeuble_id . '
                      GROUP BY NumRad) as grouped_rel_chaufs'),
                    function ($join) {
                        $join->on('rel_chaufs.NumRad', '=', 'grouped_rel_chaufs.NumRad')
                            ->on('rel_chaufs.DatRel', '=', 'grouped_rel_chaufs.LatestDate');
                    })
                ->orderBy('DatRel', 'desc')
                ->get();


        } elseif ($chaufsType == 'RADIO' || $chaufsType == 'GPRS') {

            $results = RelRadChf::select('rel_rad_chfs.*')
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->join(DB::raw('(SELECT MAX(DatRel) as LatestDate, Numcal
                      FROM rel_rad_chfs
                      WHERE Codecli = ' . $Codecli_id . ' AND RefAppTR = ' . $immeuble_id . '
                      GROUP BY Numcal) as grouped_rel_rad_chfs'),
                    function ($join) {
                        $join->on('rel_rad_chfs.Numcal', '=', 'grouped_rel_rad_chfs.Numcal')
                            ->on('rel_rad_chfs.DatRel', '=', 'grouped_rel_rad_chfs.LatestDate');
                    })
                ->orderBy('DatRel', 'desc')
                ->get();

        }



        array_push($relChaufs, $results);

        return $relChaufs;

    }

    private function getRelEau($Codecli_id, $immeuble_id)
{
    $relEau = [];

    $relEauF = RelEauF::select('rel_eau_f_s.*')
        ->where('Codecli', $Codecli_id)
        ->where('RefAppTR', $immeuble_id)
        ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
              FROM rel_eau_f_s
              WHERE Codecli = ' . $Codecli_id . ' AND RefAppTR = ' . $immeuble_id . '
              GROUP BY NumCpt) as grouped_rel_eau_fs'),
            function ($join) {
                $join->on('rel_eau_f_s.NumCpt', '=', 'grouped_rel_eau_fs.NumCpt')
                    ->on('rel_eau_f_s.DatRel', '=', 'grouped_rel_eau_fs.LatestDate');
            })
        ->orderBy('DatRel', 'desc')
        ->get();

    $relEauC = RelEauC::select('rel_eau_c_s.*')
        ->where('Codecli', $Codecli_id)
        ->where('RefAppTR', $immeuble_id)
        ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
              FROM rel_eau_c_s
              WHERE Codecli = ' . $Codecli_id . ' AND RefAppTR = ' . $immeuble_id . '
              GROUP BY NumCpt) as grouped_rel_eau_cs'),
            function ($join) {
                $join->on('rel_eau_c_s.NumCpt', '=', 'grouped_rel_eau_cs.NumCpt')
                    ->on('rel_eau_c_s.DatRel', '=', 'grouped_rel_eau_cs.LatestDate');
            })
        ->orderBy('DatRel', 'desc')
        ->get();

    $relRadEau = RelRadEau:: select('rel_rad_eaus.*')
        ->where('Codecli', $Codecli_id)
        ->where('RefAppTR', $immeuble_id)
        ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, Numcal
              FROM rel_rad_eaus
              WHERE Codecli = ' . $Codecli_id . ' AND RefAppTR = ' . $immeuble_id . '
              GROUP BY Numcal) as grouped_rel_rad_eaus'),
            function ($join) {
                $join->on('rel_rad_eaus.Numcal', '=', 'grouped_rel_rad_eaus.Numcal')
                    ->on('rel_rad_eaus.DatRel', '=', 'grouped_rel_rad_eaus.LatestDate');
            })
        ->orderBy('DatRel', 'desc')
        ->get();


   array_push($relEau, $relEauF, $relEauC, $relRadEau);





    return $relEau;

}

   private function getNotes($appartement)
    {

        return  NotesAppartement::where('appartement_id', $appartement->id)
            ->orderBy('created_at', 'desc')
            ->get();


    }

//    private function getNbImmAbsent($Codecli_id)
//    {
//        // Fetch all apartments related to the given client
//        // Count the number of apartments that are marked as absent
//        $appartements = Appartement::with('Absent')
//            ->where('Codecli', $Codecli_id)
//            ->get();
//
//        $nbImmAbsent = 0;
//
//        foreach ($appartements as $appartement) {
//            if ($appartement->Absent->count() > 0) {
//                if ($appartement->Absent->first()->is_absent) {
//                    $nbImmAbsent++;
//                }
//            }
//        }
//
//        return $nbImmAbsent;
//    }

    public function store(FileStorageFormRequest $request)
    {


        if ($request->validated()) {
            // Store files first

            $files = $request->file('files');


            $appareil = Appareil::where('numSerie', $request->request->get('numSerie'))->first();

            foreach ($files as $file) {

                // $new_filename is unique and based on timestamp
                $new_filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                // check if folder exists

                //                $path = storage_path('app/public/uploads');
                $current_user = auth()->user()->id;

                $path_to_save = 'public/img';

                if (! is_dir(storage_path('app/'.$path_to_save))) {
                    mkdir(storage_path('app/'.$path_to_save), 0777, true);
                }

                $file->storeAs($path_to_save, $new_filename);

                // Create Entry in DB in FileStorage for each file
                // hash is md5 of file
                $hash = md5_file($file->getRealPath());

                $FileStorage = new FileStorage();

                $FileStorage->filename = $new_filename;
                $FileStorage->original_filename = $file->getClientOriginalName();
                $FileStorage->path = $path_to_save;
                $FileStorage->extension = $file->getClientOriginalExtension();
                $FileStorage->mime_type = $file->getMimeType();
                $FileStorage->size = $file->getSize();
                $FileStorage->hash = $hash;
                $FileStorage->description = $request->description;
                $FileStorage->is_public = false;
                $FileStorage->is_active = true;
                $FileStorage->user_id = $current_user;
                $FileStorage->codeCli = $request->request->get('Codecli');
                if($appareil != null){
                    $FileStorage->appareil_id = $appareil->id;
                }
                $FileStorage->save();

            }

        }

        $message = __('Le fichier :filename a été créé avec succès.', [
            'filename' => 'test',
        ]);

        return redirect()->back()->with('success', $message);

    }

    public function storeNote(Request $request)
    {

        $data = $request->validate([
            'notesCH' => 'nullable|string',
            'notesEC' => 'nullable|string',
            'notesEF' => 'nullable|string',
            'notesJA' => 'nullable|string',
            'Codecli' => 'required|integer',
            'RefAppTR' => 'required|string',
            'numSerie' => 'required|string',

        ]);


        $appartement = Appartement::where('Codecli', $data['Codecli'])
            ->where('RefAppTR', $data['RefAppTR'])
            ->firstOrFail();

        $noteTypes = ['CH', 'EC', 'EF', 'JA'];
        $noteUpdated = false;

        foreach ($noteTypes as $noteType) {
            $oldNote = NotesAppartement::where('appartement_id', $appartement->id)
                ->where('type', $noteType)
                ->orderBy('created_at', 'desc')
                ->first();

            if (! $oldNote || $oldNote->note != $data['notes'.$noteType]) {
                $appareil = null;
                if(isset($data['numSerie'])) {
                    $appareil = Appareil::where('numSerie', $data['numSerie'])->first();
                }

                NotesAppartement::create([
                    'appartement_id' => $appartement->id,
                    'type' => $noteType,
                    'note' => $data['notes'.$noteType],
                    'user_id' => auth()->user()->id,
                    'appareil_id' => $appareil != null ? $appareil->id : null,
                ]);
                $noteUpdated = true;
            }
        }

        return redirect()->back()->with('success', 'Notes mis à jour !');
    }

    public function storeAbsent(Request $request)
    {
        //        dd($request->all());
        $data = $request->validate([
            //            'is_absent' => 'required|boolean',
            'Codecli' => 'required|integer',
            'RefAppTR' => 'required|string',
            'Appartement_id' => 'required|integer',
        ]);

        $is_absent = $request->input('is_absent') !== null ? $request->input('is_absent') : false;

        $oldAbsent = Absent::where('appartement_id', $data['Appartement_id'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $oldAbsent) {
            // create new note
            Absent::create([
                'appartement_id' => $data['Appartement_id'],
                'is_absent' => $is_absent,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            //            dd($data, $oldAbsent, $is_absent);
            $oldAbsent->is_absent = $is_absent;
            $oldAbsent->user_id = auth()->user()->id;
            $oldAbsent->save();
        }

        return redirect()->back()->with('success', 'Absent mis à jour ! (Appartement '.str_pad($data['RefAppTR'], 4, '0', STR_PAD_LEFT).')');
    }


}
