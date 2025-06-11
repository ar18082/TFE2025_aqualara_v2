<?php

namespace App\Http\Controllers;

use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelElecApp;
use App\Models\RelGazApp;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\RelChauf;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelGaz;
use App\Models\RelElec;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReleveController extends Controller
{
    public function index($codeCli)
    {

        $client = Client::where('Codecli', $codeCli)
            ->with(['clichaufs', 'cliEaus', 'gerantImms', 'codePostelbs'])
            ->first();


        $appartements = Appartement::where('Codecli', $codeCli)
            ->select('RefAppTR', 'RefAppCli')
            ->with('relChaufApps', 'relEauApps', 'relGazApps', 'relElecApps')
            ->orderBy('RefAppTR')
            ->get();

        $nbImmAbsent = 0;

       

        return view('immeubles.releves.index', [
            'codeCli' => $codeCli,
            'appartements' => $appartements,
            'client' => $client,
            'nbImmAbsent' => 0,
            'type' => 'chauffage',
        ]);
    }

    public function getParam(Request $request)
    {

       
        $type = $request->type;
        $codeCli = $request->codeCli;
        $refAppTR = $request->refAppTR;

        $client = Client::where('Codecli', $codeCli)
        ->with(['clichaufs', 'cliEaus', 'cliGazs', 'cliElecs'])
        ->first();
        // Récupération des paramètres selon le type
        $parametres = match($type) {
            'chauffage' => RelChaufApp::where('Codecli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->orderBy('DatRel', 'desc')
                ->first(),
            'eau' => RelEauApp::where('Codecli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->orderBy('DatRel', 'desc')
                ->first(),
            'gaz' => RelGazApp::where('Codecli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->orderBy('DatRel', 'desc')
                ->first(),
            'elec' => RelElecApp::where('Codecli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->orderBy('DatRel', 'desc')
                ->first(),
        };

        return view('immeubles.releves.types.parametres', compact('type', 'parametres'));
    }


    public function getSaisie(Request $request)
    {
        $type = $request->type;
        $codeCli = $request->codeCli;
        $refAppTR = $request->refAppTR;

        $client = Client::where('Codecli', $codeCli)
            ->with(['clichaufs', 'cliEaus', 'cliGazs', 'cliElecs'])
            ->first();

            

        switch ($type){
            case 'chauffage' :
                if($client->clichaufs[0]->TypRlv == 'VISU') {
                    $datas = RelChauf::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.DatRel)'))
                                ->from('rel_chaufs as rc2')
                                ->whereColumn('rc2.NumRad', 'rel_chaufs.NumRad')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();
                }else {
                    $datas = RelRadChf::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.DatRel)'))
                                ->from('rel_rad_chfs as rc2')
                                ->whereColumn('rc2.Numcal', 'rel_rad_chfs.Numcal')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();
                };
                break;
            case 'eau' :

                if($client->cliEaus[0]->TypRlv == 'VISU') {
                    $datas = RelEauF::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.DatRel)'))
                                ->from('rel_eau_f_s as rc2')
                                ->whereColumn('rc2.NumCpt', 'rel_eau_f_s.NumCpt')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();

                    $datas2 = RelEauC::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('DatRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.DatRel)'))
                                ->from('rel_eau_c_s as rc2')
                                ->whereColumn('rc2.NumCpt', 'rel_eau_c_s.NumCpt')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();


                    return view('immeubles.releves.types.saisie', compact('type', 'datas', 'datas2'));
                   
                }else {
                    $datas = RelRadEau::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->orderBy('DatRel', 'desc')
                        ->get();
                }
        
                
                break;
            case 'gaz' :
                $datas = RelGaz::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('datRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.datRel)'))
                                ->from('rel_gaz as rc2')
                                ->whereColumn('rc2.numCpt', 'rel_gaz.numCpt')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();
                break;
            case 'elec' :
                $datas = RelElec::where('Codecli', $codeCli)
                        ->where('RefAppTR', $refAppTR)
                        ->where('datRel', function ($query) use ($codeCli, $refAppTR) {
                            $query->select(DB::raw('MAX(rc2.datRel)'))
                                ->from('rel_elecs as rc2')
                                ->whereColumn('rc2.numCpt', 'rel_elecs.numCpt')
                                ->where('rc2.Codecli', $codeCli)
                                ->where('rc2.RefAppTR', $refAppTR);
                        })
                        ->get();
                break;           
                
        }    

  



        return view('immeubles.releves.types.saisie', compact('type', 'datas'));

    }

    public function show($type, $codeCli, $refAppTR)
    {
        return view('immeubles.releves.types.' . $type, [
            'codeCli' => $codeCli,
            'refAppTR' => $refAppTR
        ]);
    }

    public function getAppartements(Request $request)
    {
        $validated = $request->validate([
            'codeCli' => 'required|string'
        ]);

        $appartements = Appartement::where('Codecli', $validated['codeCli'])
            ->select('RefAppTR', 'RefAppCl')
            ->orderBy('RefAppTR')
            ->get();

        return response()->json($appartements);
    }

    public function getData(Request $request)
    {
        $validated = $request->validate([
            'codeCli' => 'required|string',
            'refAppTR' => 'required|string',
            'type' => 'required|in:chauffage,eau,gaz,elec'
        ]);

        $data = match($validated['type']) {
            'chauffage' => DB::table('rel_chaufs')
                ->where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->where('DatRel', function ($query) use ($validated) {
                    $query->select(DB::raw('MAX(DatRel)'))
                        ->from('rel_chaufs')
                        ->where('Codecli', $validated['codeCli'])
                        ->where('RefAppTR', $validated['refAppTR']);
                })
                ->get(),
            'eau' => DB::table('rel_eau_f_s')
                ->where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->where('DatRel', function ($query) use ($validated) {
                    $query->select(DB::raw('MAX(DatRel)'))
                        ->from('rel_eau_f_s')
                        ->where('Codecli', $validated['codeCli'])
                        ->where('RefAppTR', $validated['refAppTR']);
                })
                ->get(),
            default => []
        };

        return response()->json($data);
    }

    public function getParameters(Request $request)
    {
        $validated = $request->validate([
            'codeCli' => 'required|string',
            'refAppTR' => 'required|string',
            'type' => 'required|in:chauffage,eau,gaz,elec'
        ]);

        $parameters = match($validated['type']) {
            'chauffage' => RelChaufApp::where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->orderBy('DatRel', 'desc')
                ->first(),
            'eau' => RelEauApp::where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->orderBy('DatRel', 'desc')
                ->first(),
            'gaz' => RelGazApp::where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->orderBy('DatRel', 'desc')
                ->first(),
            'elec' => RelElecApp::where('Codecli', $validated['codeCli'])
                ->where('RefAppTR', $validated['refAppTR'])
                ->orderBy('DatRel', 'desc')
                ->first(),
        };

        return response()->json($parameters);
    }

    public function updateLockState(Request $request)
    {
        $validated = $request->validate([
            'appRef' => 'required|string',
            'type' => 'required|in:chauffage,eau,gaz,elec',
            'state' => 'required|in:locked,unlocked'
        ]);

        try {
            DB::beginTransaction();

            $model = match($validated['type']) {
                'chauffage' => RelChaufApp::class,
                'eau' => RelEauApp::class,
                'gaz' => RelGazApp::class,
                'elec' => RelElecApp::class,
            };

            $record = $model::where('RefAppTR', $validated['appRef'])
                ->orderBy('DatRel', 'desc')
                ->first();

            if (!$record) {
                throw new \Exception('Enregistrement non trouvé');
            }

            $record->update([
                'Statut' => $validated['state'] === 'locked' ? 'V' : 'N'
            ]);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 