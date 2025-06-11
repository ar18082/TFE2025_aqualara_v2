<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materiel;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\inArray;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiels = Materiel::orderBy('nom')->paginate(25);

        return view('admin.materiel.index', [
            'materiels' => $materiels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $appareil = new Materiel();


        return view('admin.materiel.form(2)', [
            'appareil' => $appareil,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tpsRG = [
            'Visuel' => 90,
            'Lora' => 0,
            'WM-Bus' => 2.4,
            'radioSontex' => 10,
            'M-Bus'=> 1800,
            'Impulsion' => 1800,
            'M-Bus-3EP' => 1800,
            'WM-Bus-3EP' => 2.4,

        ];

//        dd($tpsRG);
//        dd($request->all());
        $datas = $request->all();

        $materiel = new Materiel();
        $materiel->nom = $datas['materiel'];
        $materiel->genre = $datas['cpt_genre'];
        $materiel->type = $datas['type_compteur'] ?? null;
        $materiel->dimension = $datas['dimension_compteur'] ?? null;
        $materiel->communication = $datas['cpt_commu_modul'];
        $materiel->model = $datas['cpt_modul_model'];
        if (array_key_exists($datas['cpt_commu_modul'], $tpsRG)) {
            $materiel->tps_RG = $tpsRG[$datas['cpt_commu_modul']];
        }
        if($datas['materiel'] == 'Integrateur'){
            $materiel->tps_rplt = 900;
            $materiel->tps_plt = null;
        }




        $materiel->save();
        //dd($materiel);

        $message = __('Le matériel a été créé avec succès.');

        return redirect()->route('admin.materiel.index')->with('success', $message);
    }

    public function destroy($id)
    {

        $materiel = Materiel::find($id);
        $materiel->delete();


        $message = __('Le matériel :nom a été supprimé avec succès.', [
            'nom'=>$materiel->nom,

        ]);

        return to_route('admin.materiel.index')->with('success', $message);
    }

    public function searchByMateriel(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;


            $data = Materiel::where('nom', 'LIKE', "%$search%")->get();


        }


        return response()->json($data);
    }

}
