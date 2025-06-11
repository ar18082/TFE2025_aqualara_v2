<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyFormRequest;
use App\Models\Appareil;
use App\Models\AppareilsErreur;
use App\Models\Appartement;
use App\Models\Clichauf;
use App\Models\Client;
use App\Models\FileStorage;
use App\Models\NotesAppartement;
use App\Models\relApp;
use App\Models\RelChauf;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use Illuminate\Http\Request;
use Tests\Laravel\App;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {


        if ($request->has('codeimmeuble')) {
            if($request->has('codeimmeuble') == null){
                $codeimmeuble = '';

            }else{
                $codeimmeuble = $request->input('codeimmeuble');
                $codeimmeuble = intval($codeimmeuble);
            }
        } else {
            $codeimmeuble = '';
        }


        if ($request->has('nom')) {
            if($request->has('nom') == null){
                $nom = '';
            }else {
                $nom = $request->input('nom');
            }

        } else {
            $nom = '';
        }

        if ($request->has('cp_localite')) {
            if($request->has('cp_localite') == null){
                $cp_localite = '';
            }else {
                $cp_localite = $request->input('cp_localite');
            }

        } else {
            $cp_localite = '';
        }

        if ($request->has('chauftype')) {
            if($request->has('chauftype') == null){
                $chauftype = '';
            }else {
                $chauftype = $request->input('chauftype');
            }
        } else {
            $chauftype = '';
        }

        if ($request->has('eautype')) {
            if($request->has('eautype') == null){
                $eautype = '';
            }else {
                $eautype = $request->input('eautype');
            }

        } else {
            $eautype = '';
        }

        if ($codeimmeuble == ''  && $nom == '' && $cp_localite == '' && $chauftype == '' && $eautype == '') {

            $clients = Client::with('gerantImms')->with('codePostelbs')->whereHas('appartements')->orderBy('Codecli', 'asc')->paginate(25);

        } else {
            $clients = Client::with('gerantImms')->with('codePostelbs')->whereHas('appartements')->orderBy('Codecli', 'asc');

            if ($chauftype != '') {
                $clients = $clients->where(function ($query) use ($chauftype) {
                    if ($chauftype != 'all' && $chauftype != 'none') {
                        $query->whereHas('clichaufs', function ($subQuery) use ($chauftype) {
                            $subQuery->where('TypRlv', '=', $chauftype);
                        });
                    } elseif ($chauftype == 'none') {
                        $query->whereDoesntHave('clichaufs');
                    }
                });
            }

            if ($eautype != '') {
                $clients = $clients->where(function ($query) use ($eautype) {
                    if ($eautype != 'all' && $eautype != 'none') {
                        $query->whereHas('cliEaus', function ($subQuery) use ($eautype) {
                            $subQuery->where('TypRlv', '=', $eautype);
                        });
                    } elseif ($eautype == 'none') {
                        $query->whereDoesntHave('cliEaus');
                    }
                });
            }

            if ($codeimmeuble != '') {
                $clients = $clients->where('Codecli', $codeimmeuble);
            }

            if ($nom != '') {
                $clients = Client::where('id', $nom);
            }



            if ($cp_localite != '') {

                $clients = $clients->whereHas('codePostelbs', function ($query) use ($cp_localite) {
                    $query->where('code_postelb_id', '=', $cp_localite);
                });



            }

            $clients = $clients->paginate(25);
        }
        return view('admin.property.index', [
            'clients' => $clients,
        ]);

    }



public function  show ($id)
{
    // check if $id exists if not return to index
    $client = Client::with('gerantImms', 'relApps')
        ->with('codePostelbs')
        ->with('clichaufs')
        ->with('cliEaus')
        ->with('relChaufApps')
        ->with('relEauApps')
        ->where('Codecli', $id)
        ->firstOrFail();
    //        'gerantImms')->with('rel_apps')->where('Codecli', $id)->firstOrFail();'

    $relApps = relApp::where('Codecli', $id)->get();

    $appartements = Appartement::with('Absent')
        ->where('Codecli', $id)->paginate(50);

    $appartements_for_count = Appartement::with('Absent')
        ->where('Codecli', $id)->get();

    $nbImmAbsent = 0;

    foreach ($appartements_for_count as $appartement) {
        if ($appartement->Absent->count() > 0) {
            if ($appartement->Absent->first()->is_absent) {
                $nbImmAbsent++;
            }
        }
    }

    //        dd($appartements);
    return view('admin.property.property', [
        'Codecli' => $id,
        'appartements' => $appartements,
        'client' => $client,
        'relApps' => $relApps,
        'nbImmAbsent' => $nbImmAbsent,

    ]);
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
    $appartements_for_count = Appartement::with('Absent')
        ->where('Codecli', $Codecli_id)->get();

    $nbImmAbsent = 0;

    foreach ($appartements_for_count as $appartement) {
        if ($appartement->Absent->count() > 0) {
            if ($appartement->Absent->first()->is_absent) {
                $nbImmAbsent++;
            }
        }
    }

    switch ($type) {
        case 'VISU_EAU_C':
            $rel_Filtered = RelEauC::where('NumCpt', $ref)
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->get();
            break;
        case 'VISU_EAU_F':
            $rel_Filtered = RelEauF::where('NumCpt', $ref)
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->get();
            break;
        case 'RADIO_EAU' :
            $rel_Filtered = RelEauF::where('NumCpt', $ref)
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->get();
            break;
        case 'VISU_CH':
            $rel_Filtered = RelChauf::where('NumCal', $ref)
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->get();
            break;
        case 'RADIO_CH':
            $rel_Filtered = RelRadChf::where('Numcal', $ref)
                ->where('Codecli', $Codecli_id)
                ->where('RefAppTR', $immeuble_id)
                ->get();

            break;

    }





    return view('admin.property.showReleveProperty', [
        'Codecli' => $Codecli_id,
        'appartement' => $appartement,
        'client' => $client,
        'nbImmAbsent' => $nbImmAbsent,
        'relApps' => $relApps,
        'immeuble_id' => $immeuble_id,
        'type' => $type,
        'rel_Filtered' => $rel_Filtered,

    ]);
}


public function showProperty($codeCli, $appartement_id){
    // check if $id exists if not return to index
    $client = Client::with('gerantImms', 'relApps')
        ->with('codePostelbs')
        ->with('clichaufs')
        ->with('cliEaus')
        ->with('relChaufApps')
        ->with('relEauApps')
        ->where('Codecli', $codeCli)
        ->firstOrFail();


    $relApps = relApp::where('Codecli', $codeCli)->where('RefAppTr', $appartement_id)->get();

    $appartement = Appartement::with('notesAppartements')
        ->where('Codecli', $codeCli)->where('RefAppTR', $appartement_id)->firstOrFail();



    $chauType = $client->clichaufs->get(0);

    if (isset($chauType->TypRlv) && $chauType->TypRlv == 'VISU') {
        $chaufsType = 'VISU';
        $rel_Chaufs = RelChauf::select('rel_chaufs.*')
            ->where('Codecli', $codeCli)
            ->where('RefAppTR', $appartement_id)
            ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumRad
                      FROM rel_chaufs
                      WHERE Codecli = '.$codeCli.' AND RefAppTR = '.$appartement_id.'
                      GROUP BY NumRad) as grouped_rel_chaufs'),
                function ($join) {
                    $join->on('rel_chaufs.NumRad', '=', 'grouped_rel_chaufs.NumRad')
                        ->on('rel_chaufs.DatRel', '=', 'grouped_rel_chaufs.LatestDate');
                })
            ->orderBy('DatRel', 'desc')
            ->get();



    } elseif (isset($chauType->TypRlv) && ($chauType->TypRlv == 'GPRS' or $chauType->TypRlv == 'RADIO')) {
        $chaufsType = 'RADIO';
        $DateLastRel = RelRadChf::select('DatRel')
            ->where('Codecli', $codeCli)
            ->where('RefAppTR', $appartement_id)
            ->orderBy('DatRel', 'desc')
            ->first();
        if (isset($DateLastRel->DatRel)) {
            $DateLastRel = $DateLastRel->DatRel;
        } else {
            $DateLastRel = null;
        }

        $rel_Chaufs = RelRadChf::select('rel_rad_chfs.*')
            ->where('Codecli', $codeCli)
            ->where('RefAppTR', $appartement_id)
//                ->where('DatRel', $DateLastRel)
            ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, Numcal
                      FROM rel_rad_chfs
                      WHERE Codecli = '.$codeCli.' AND RefAppTR = '.$appartement_id.'
                      GROUP BY Numcal) as grouped_rel_rad_chfs'),
                function ($join) {
                    $join->on('rel_rad_chfs.Numcal', '=', 'grouped_rel_rad_chfs.Numcal')
                        ->on('rel_rad_chfs.DatRel', '=', 'grouped_rel_rad_chfs.LatestDate');
                })
            ->orderBy('DatRel', 'desc')
            ->get();


    } else {

    }

    if ($client->cliEaus->get(0) == null) {
        $eauType = '';
    } else {
        $eauType = $client->cliEaus->get(0)->TypRlv;
    }

    $rel_eau_fs = RelEauF::select('rel_eau_f_s.*')
        ->where('Codecli', $codeCli)
        ->where('RefAppTR', $appartement_id)
        ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
                      FROM rel_eau_f_s
                      WHERE Codecli = '.$codeCli.' AND RefAppTR = '.$appartement_id.'
                      GROUP BY NumCpt) as grouped_rel_eau_fs'),
            function ($join) {
                $join->on('rel_eau_f_s.NumCpt', '=', 'grouped_rel_eau_fs.NumCpt')
                    ->on('rel_eau_f_s.DatRel', '=', 'grouped_rel_eau_fs.LatestDate');
            })
        ->orderBy('DatRel', 'desc')
        ->get();



    $rel_eau_cs = RelEauC::select('rel_eau_c_s.*')
        ->where('Codecli', $codeCli)
        ->where('RefAppTR', $appartement_id)
        ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
                      FROM rel_eau_c_s
                      WHERE Codecli = '.$codeCli.' AND RefAppTR = '.$appartement_id.'
                      GROUP BY NumCpt) as grouped_rel_eau_cs'),
            function ($join) {
                $join->on('rel_eau_c_s.NumCpt', '=', 'grouped_rel_eau_cs.NumCpt')
                    ->on('rel_eau_c_s.DatRel', '=', 'grouped_rel_eau_cs.LatestDate');
            })
        ->orderBy('DatRel', 'desc')
        ->get();

    $attributes = [];
    foreach ($rel_eau_fs as $rel_eau_f) {
        $attributes = $rel_eau_f->getAttributes();
        $allAttributes[] = $attributes;
        // Affiche la liste des 20 attributs

    }

    //dd($allAttributes[0]->TypRlv);



    $notesCH = NotesAppartement::where('appartement_id', $appartement->id)->where('type', 'CH')->orderBy('created_at', 'desc')->first();
    $notesEC = NotesAppartement::where('appartement_id', $appartement->id)->where('type', 'EC')->orderBy('created_at', 'desc')->first();
    $notesEF = NotesAppartement::where('appartement_id', $appartement->id)->where('type', 'EF')->orderBy('created_at', 'desc')->first();
    $notesJA = NotesAppartement::where('appartement_id', $appartement->id)->where('type', 'JA')->orderBy('created_at', 'desc')->first();



    $appartements_for_count = Appartement::with('Absent')
        ->where('Codecli', $codeCli)->get();

    $nbImmAbsent = 0;

    foreach ($appartements_for_count as $appartement) {
        if ($appartement->Absent->count() > 0) {
            if ($appartement->Absent->first()->is_absent) {
                $nbImmAbsent++;
            }
        }
    }

    $files = FileStorage::select('*')
        ->where('codeCli', $codeCli)

        ->get();

    return view('admin.property.propertyDetail', [
        'Codecli' => $codeCli,
        'appartement' => $appartement,
        'client' => $client,
        'relApps' => $relApps,
        'rel_Chaufs' => $rel_Chaufs,
        'rel_eau_cs' => $rel_eau_cs,
        'rel_eau_fs' => $rel_eau_fs,
        'chaufsType' => $chaufsType,
        'eauType' => $eauType,
        'notesCH' => $notesCH,
        'notesEC' => $notesEC,
        'notesEF' => $notesEF,
        'notesJA' => $notesJA,
        'nbImmAbsent' => $nbImmAbsent,
        'files' => $files,
        'immeuble_id' => $appartement_id,

    ]);

}
        /*
         * faire apparaitre les clients qui n'ont pas d'appartement lié
         * voir si comment faire la requete
         * on va récupérer tous les clients qui n'ont pas d'appartement



        $clients = Client::orderBy('Codecli')->paginate(25);

        dd($clients);


        return view('admin.property.index', [
            'properties' => Appartement::orderBy('Codecli')->paginate(25),
        ]);
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function addProperty($codeCli)
    {

        $lastProperty = Appartement::where('Codecli', $codeCli)
            ->latest('RefAppTR')
            ->first();

        $lastRefAppTR=$lastProperty->RefAppTR + 1;


        $property = new Appartement();
        /*$client = new Client();

        $nbChauf = $client[0]->relChaufApps->where('RefAppTR', $RefAppTR)->last();
        $nbEau = $client[0]->relEauApps->where('RefAppTR', $RefAppTR)->last();
        $relApp = $client[0]->relApps->where('RefAppTR', $RefAppTR)->last();*/


        return view('admin.property.form', [
            'property' => $property,
            'codeCli' => $codeCli,
            'lastRefAppTR'=>$lastRefAppTR,
            'ProprioCd' => '',
            'nbr_chauf' => '',
            'nbr_eauC' =>'',
            'nbr_eauF' => '',
            'LocatCd' => '',

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->input('codeCli');


        $client = Client::with('gerantImms', 'relApps')
            ->with('codePostelbs')
            ->with('clichaufs')
            ->with('cliEaus')
            ->with('relChaufApps')
            ->with('relEauApps')
            ->where('Codecli', $id)
            ->firstOrFail();

        $relApps = relApp::where('Codecli', $id)->get();

        $appartements = Appartement::with('Absent')
            ->where('Codecli', $id)->paginate(50);

        $appartements_for_count = Appartement::with('Absent')
            ->where('Codecli', $id)->get();

        $nbImmAbsent = 0;
        $refAppTR = $request->input('RefAppTR');

        foreach ($appartements_for_count as $appartement) {
            if ($appartement->Absent->count() > 0) {
                if ($appartement->Absent->first()->is_absent) {
                    $nbImmAbsent++;
                }
            }
        }

        $client_id = Client::where('Codecli', $id)->first();
        $nbr_rad = $request->input('nbr_rad');
        $nbr_EC = $request->input('nbr_ComptEC');
        $nbr_EF = $request->input('nbr_ComptEF');
        $refAppTR = $request->input('RefAppTR');

        $newAppart = new Appartement();
        $newAppart->CodeCli = $id;
        $newAppart->RefAppTR = $refAppTR;
        $newAppart->proprietaire = $request->input('NomProp');
        $newAppart->RefAppCli = $request->input('RefAppCli');

        //$newAppart->save();

        $clichaufs = new Clichauf();
        $clichaufs->client_id = $client_id;
        $clichaufs->Codecli = $id;
        $clichaufs->Quotite = $request->input('nbr_Quot');

        // $clichaufs->save();

        // ajout calorimetre
         for ($i = 0; $i < $nbr_rad; $i++) {
             $serialNumber_cal = 'serialNumber_cal_' . $i;
             $type_cal = 'type_cal_' . $i;
             $situation_cal = 'situation_cal_' . $i;
             $coefficient_cal = 'coefficient_cal_' . $i;
             $status_cal = 'status_cal_' . $i;

             if($request->input($type_cal) == 'VISU'){
                 $relChauf = new RelChauf();
                 $relChauf->NumCal = $request->input($serialNumber_cal);
                 $relChauf->Codecli = $id;
                 $relChauf-> TypCal = $request->input($type_cal);
                 $relChauf-> Sit = $request->input($situation_cal);
                 $relChauf-> Coef = $request->input($coefficient_cal);
                 $relChauf-> Statut = $request->input($status_cal);
                 $relChauf-> AncIdx = 0;
                 $relChauf-> NvIdx = 0;
                 $relChauf-> NvIdx2 = 0;
             }elseif ($request->input($type_cal) == 'RADIO'){
                 $RelRadChf = new RelRadChf();
                 $RelRadChf->Numcal = $request->input($serialNumber_cal);
                 $RelRadChf->Codecli = $id;
                 $RelRadChf->RefAppTR = $refAppTR;
                 $RelRadChf-> Nvidx = 0;
                 $RelRadChf-> Coef = $request->input($coefficient_cal);
                 //$RelRadChf-> TypCal = $request->input($type_cal);
                 //$RelRadChf-> Sit = $request->input($situation_cal);
                 //$RelRadChf-> Statut = $request->input($status_cal);
             }
         }

         // appareil eau chaude

         for($ec = 0; $ec < $nbr_EC; $ec++){
             $serialNumber_EC = 'serialNumber_EC_' . $i;
             $type_EC = 'type_EC_' . $i;
             $situation_EC = 'situation_EC_' . $i;
             $coefficient_EC = 'coefficient_EC_' . $i;
             $status_EC = 'status_EC_' . $i;
             if($request->input($type_EC) == 'VISU'){
                 $relEauC = new RelEauC();
                 $relEauC->NumCpt = $request->input($serialNumber_EC);
                 $relEauC->Codecli = $id;
                 $relEauC-> TypCal = $request->input($type_EC);
                 $relEauC-> Sit = $request->input($situation_EC);
                 $relEauC-> Coef = $request->input($coefficient_EC);
                 $relEauC-> Statut = $request->input($status_EC);
                 $relEauC-> AncIdx = 0;
                 $relEauC-> NvIdx = 0;
                 $relEauC-> NvIdx2 = 0;

             }elseif ($request->input($type_EC) == 'RADIO'){
                 $RelRadEau = new RelRadEau();
                 $RelRadEau->Numcal = $request->input($serialNumber_EC);
                 $RelRadEau->Codecli = $id;
                 $RelRadEau->RefAppTR = $refAppTR;
                 $RelRadEau-> Nvidx = 0;
                 //$RelRadEau-> TypCal = $request->input($type_EC);
                 //$RelRadEau-> Sit = $request->input($situation_EC);
                 //$RelRadEau-> Coef = $request->input($coefficient_EC);
                 //$RelRadEau-> Statut = $request->input($status_EC);
             }
         }

        // appareil eau froide

        for($ef = 0; $ef < $nbr_EF; $eF++){
            $serialNumber_EF = 'serialNumber_EF_' . $i;
            $type_EF = 'type_EF_' . $i;
            $situation_EF = 'situation_EF_' . $i;
            $coefficient_EF = 'coefficient_EF_' . $i;
            $status_EF = 'status_EF_' . $i;
            if($request->input($type_EF) == 'VISU'){
                $relEauF = new RelEauF();
                $relEauF->NumCpt = $request->input($serialNumber_EF);
                $relEauF->Codecli = $id;
                $relEauF-> TypCal = $request->input($type_EF);
                $relEauF-> Sit = $request->input($situation_EF);
                $relEauF-> Coef = $request->input($coefficient_EF);
                $relEauF-> Statut = $request->input($status_EF);
                $relEauF-> NvIdx = 0;
                $relEauF-> AncIdx = 0;
                $relEauC-> NvIdx2 = 0;

            }elseif ($request->input($type_EC) == 'RADIO'){
                $RelRadEau = new RelRadEau();
                $RelRadEau->Numcal = $request->input($serialNumber_EF);
                $RelRadEau->Codecli = $id;
                $RelRadEau->RefAppTR = $refAppTR;
                $relEauF-> Nvidx = 0;
                //$RelRadEau-> TypCal = $request->input($type_EC);
                //$RelRadEau-> Sit = $request->input($situation_EC);
                //$RelRadEau-> Coef = $request->input($coefficient_EC);
                //$RelRadEau-> Statut = $request->input($status_EC);
            }
        }


        $message = __('L\'appartement :RefAppTR a été créé avec succès.', [
            'RefAppTR' => $refAppTR,
        ]);

        return view('admin.property.property', [
                   'Codecli' => $id,
                   'appartements' => $appartements,
                   'client' => $client,
                   'relApps' => $relApps,
                   'nbImmAbsent' => $nbImmAbsent,
                   'success' => $message,

               ]);
    }


    /**
     * Show the form for editing the specified resource.
     */


//    public function edit( $Codecli, $RefAppTR )
//    {
//       $client = Client::where('Codecli', $Codecli)->get();
//
//        $property = Appartement::where('Codecli', $Codecli)
//            ->where('RefAppTR', $RefAppTR)
//            ->get();
//
//
//        $nbChauf = $client[0]->relChaufApps->where('RefAppTR', $RefAppTR)->last();
//        $nbEau = $client[0]->relEauApps->where('RefAppTR', $RefAppTR)->last();
//        $relApp = $client[0]->relApps->where('RefAppTR', $RefAppTR)->last();
//
//        $nbr_eauC = $nbEau != null ? $nbEau->NbCptChaud : 0;
//        $nbr_eauF = $nbEau != null ? $nbEau->NbCptFroid : 0;
//
//
//        $rel_Chaufs = RelChauf::select('rel_chaufs.*')
//            ->where('Codecli', $Codecli)
//            ->where('RefAppTR', $RefAppTR)
//            ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumRad
//                      FROM rel_chaufs
//                      WHERE Codecli = '.$Codecli.' AND RefAppTR = '.$RefAppTR.'
//                      GROUP BY NumRad) as grouped_rel_chaufs'),
//                function ($join) {
//                    $join->on('rel_chaufs.NumRad', '=', 'grouped_rel_chaufs.NumRad')
//                        ->on('rel_chaufs.DatRel', '=', 'grouped_rel_chaufs.LatestDate');
//                })
//            ->orderBy('DatRel', 'desc')
//            ->get();
//
//        $rel_eau_cs = RelEauC::select('rel_eau_c_s.*')
//            ->where('Codecli', $Codecli)
//            ->where('RefAppTR', $RefAppTR)
//            ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
//                      FROM rel_eau_c_s
//                      WHERE Codecli = '.$Codecli.' AND RefAppTR = '.$RefAppTR.'
//                      GROUP BY NumCpt) as grouped_rel_eau_cs'),
//                function ($join) {
//                    $join->on('rel_eau_c_s.NumCpt', '=', 'grouped_rel_eau_cs.NumCpt')
//                        ->on('rel_eau_c_s.DatRel', '=', 'grouped_rel_eau_cs.LatestDate');
//                })
//            ->orderBy('DatRel', 'desc')
//            ->get();
//
//
//
//        $rel_eau_fs = RelEauF::select('rel_eau_f_s.*')
//            ->where('Codecli', $Codecli)
//            ->where('RefAppTR', $RefAppTR)
//            ->join(\DB::raw('(SELECT MAX(DatRel) as LatestDate, NumCpt
//                      FROM rel_eau_f_s
//                      WHERE Codecli = '.$Codecli.' AND RefAppTR = '.$RefAppTR.'
//                      GROUP BY NumCpt) as grouped_rel_eau_fs'),
//                function ($join) {
//                    $join->on('rel_eau_f_s.NumCpt', '=', 'grouped_rel_eau_fs.NumCpt')
//                        ->on('rel_eau_f_s.DatRel', '=', 'grouped_rel_eau_fs.LatestDate');
//                })
//            ->orderBy('DatRel', 'desc')
//            ->get();
//
//        $appareilsErreurs = AppareilsErreur::where('Codecli', $Codecli)
//            ->where('RefAppTR', $RefAppTR)
//            ->get();
//
//
//
//        return view('admin.property.formProperty.formEdit', [
//            'property' => $property[0],
//            'lastRefAppTR'=>$RefAppTR,
//            'codeCli' => $Codecli,
//            'nbr_chauf' => $nbChauf->NbRad,
//            'nbr_eauC' => $nbr_eauC,
//            'nbr_eauF' => $nbr_eauF,
//            'ProprioCd' => $relApp->ProprioCd,
//            'LocatCd' => $relApp->LocatCd,
//            'rel_Chaufs' => $rel_Chaufs,
//            'rel_eau_cs' => $rel_eau_cs,
//            'rel_eau_fs' =>  $rel_eau_fs,
//            'appareilsErreurs' => $appareilsErreurs,
//
//
//        ]);
//    }

//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, Appartement $property)
//    {
//        dd($request->all());
//        $codeCli = $request->input('Codecli');
//
//        $client = Client::where('Codecli', $codeCli)->get();
//
//
//        $nbr_rad = $request->input('nbr_radiateur');
//        $nbr_EC = $request->input('nbr_ComptEC');
//        $nbr_EF = $request->input('nbr_ComptEF');
//        $refAppTR = $request->input('RefAppTR');
//
//        $appart = Appartement::where('Codecli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            ->get();
//        $appart->proprietaire = $request->input('NomProp');
//        $appart->RefAppCli = $request->input('RefAppCli');
//        //$appart->save();
//
//        $clichauf= Clichauf::where('client_id', $client[0]->id)->get();
//        $clichauf->Quotite = $request->input('nbr_Quot');
//        // $clichauf->save();
//
//
//
//        $relChauf = RelChauf::where('codeCli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            //->where('NumRad', $request->input('NumRad');
//            ->get();
//
//        $relRadChf = RelRadChf::where('codeCli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            ->get();
//
//        $relEauC = RelEauC::where('Codecli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            ->get();
//
//        $RelRadEau = RelRadEau::where('Codecli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            ->get();
//
//        $relEauF = RelEauF::where('Codecli', $codeCli)
//            ->where('RefAppTR', $refAppTR)
//            ->get();
//
//
//        //dd($request->input('type_cal_1'));
//
//        // ajout calorimetre
//        for ($i = 0; $i < $nbr_rad; $i++) {
//            $serialNumber_cal = 'serialNumber_cal_' . $i;
//            $type_cal = 'type_cal_' . $i;
//            $situation_cal = 'situation_cal_' . $i;
//            $coefficient_cal = 'coefficient_cal_' . $i;
//            $status_cal = 'status_cal_' . $i;
//
//
//
//            if($request->input($type_cal) == 'VISU'){
//
//                dd($relChauf[$i]);
//                $relChauf[$i]->NumCal = $request->input($serialNumber_cal);
//                $relChauf[$i]->TypCal = $request->input($type_cal);
//                $relChauf[$i]->Sit = $request->input($situation_cal);
//                $relChauf[$i]-> Coef = $request->input($coefficient_cal);
//                $relChauf[$i]-> Statut = $request->input($status_cal);
//
//                $relChauf[$i]->save();
//
//            }elseif ($request->input($type_cal) == 'RADIO'){
//
//                $relRadChf[$i]->Numcal = $request->input($serialNumber_cal);
//                $relRadChf[$i]-> Coef = $request->input($coefficient_cal);
//                $relRadChf[$i]->save();
//            }
//        }
//
//            // appareil eau chaude
//
//
//
//        for($ec = 0; $ec < $nbr_EC; $ec++){
//            $serialNumber_EC = 'serialNumber_EC_' . $ec;
//            $type_EC = 'type_EC_' . $ec;
//            $situation_EC = 'situation_EC_' . $ec;
//            $coefficient_EC = 'coefficient_EC_' . $ec;
//            $status_EC = 'status_EC_' . $ec;
//            if($request->input($type_EC) == 'VISU'){
//
//                $relEauC[$ec]->NumCpt = $request->input($serialNumber_EC);
//                $relEauC[$ec]-> Sit = $request->input($situation_EC);
//                $relEauC[$ec]-> Coef = $request->input($coefficient_EC);
//                $relEauC[$ec]-> Statut = $request->input($status_EC);
//                //$relEauC[$ec]->save();
//
//
//            }elseif ($request->input($type_EC) == 'RADIO'){
//                $RelRadEau[$ec]->Numcal = $request->input($serialNumber_EC);
//                //$RelRadEau[$ec]->save();
//
//            }
//        }
//
//        // appareil eau froide
//
//        for($ef = 0; $ef < $nbr_EF; $ef++){
//            $serialNumber_EF = 'serialNumber_EF_' . $ef;
//            $type_EF = 'type_EF_' . $ef;
//            $situation_EF = 'situation_EF_' . $ef;
//            $coefficient_EF = 'coefficient_EF_' . $ef;
//            $status_EF = 'status_EF_' . $ef;
//            if($request->input($type_EF) == 'VISU'){
//
//                $relEauF[$ef]->NumCpt = $request->input($serialNumber_EF);
//                $relEauF[$ef]-> TypCal = $request->input($type_EF);
//                $relEauF[$ef]-> Sit = $request->input($situation_EF);
//                $relEauF[$ef]-> Coef = $request->input($coefficient_EF);
//                $relEauF[$ef]-> Statut = $request->input($status_EF);
//               // $relEauF[$ef]->save();
//
//
//
//            }elseif ($request->input($type_EC) == 'RADIO'){
//                $RelRadEau[$ef]->Numcal = $request->input($serialNumber_EF);
//                //$RelRadEau[$ef]->save();
//
//            }
//        }
//
//
//
//        $message = __('L\'appartement :RefAppCli a été modifié avec succès.', [
//            'RefAppCli' => $property->RefAppCli,
//        ]);
//
//        return redirect()->route('immeubles.showAppartement', ['Codecli_id' => $codeCli, 'appartement_id' =>$refAppTR] )->with('success', $message);
//
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appartement $property)
    {
        $property->delete();

        $message = __('L\'appartement :RefAppCli a été supprimé avec succès.', [
            'RefAppCli' => $property->RefAppCli,
        ]);

        return redirect()->route('admin.property.index')->with('success', $message);

    }
}
