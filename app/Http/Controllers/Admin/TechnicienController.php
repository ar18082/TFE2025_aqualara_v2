<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TechnicienTypeFormRequest;
use App\Models\Client;
use App\Models\ColorTechnicien;
use App\Models\Competence;
use App\Models\Event;
use App\Models\EventTechnicien;
use App\Models\Region;
use App\Models\statusTechnicien;
use App\Models\Technicien;
use App\Models\TechnicienRegion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TechnicienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $techniciens =  Technicien::orderBy('nom')->paginate(25);

        //dd($techniciens[0]);

        return view('admin.technicien.index', [
            'techniciens' =>$techniciens
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technicien = new Technicien();

        $couleursOptionsData = ColorTechnicien::where('dispo', 1)->get();

        $regionsOptions = Region::orderBy('name')->get();

        $competencesOptions = Competence::all();

        $status = statusTechnicien::orderBy('id')->get();



        return view('admin.technicien.form', [
            'couleursOptionsData' => $couleursOptionsData,
            'technicien' =>$technicien,
            'regionsOptions' => $regionsOptions,
            'competencesOptions' => $competencesOptions,
            'status' => $status,


        ]);
    }


    public function store(Request $request)
    {
      // check input required
        $this->validate($request,[
            'nom'=>'required',
            'prenom'=>'required',
            'couleur' => 'required',

        ]);

        //recup datas
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $phone = $request->input('phone');
        $couleur = $request->input('couleur');
        $status = $request->input('status');
        $regions = $request->input('regions');
        $competences = $request->input('competences');
        $registre_national = $request->input('registre_national');
        $rue = $request->input("rue");
        $numero = $request->input('numero');
        $codePostal = $request->input('codePostal');
        $localite = $request->input('localite');


        $technicienAddress =$numero.' '.$rue. ', '.$codePostal . ' ' . $localite .', Belgique';
        $technicienCoordinates = geocodeAddress($technicienAddress);



        // traitement data
        $technicien = new Technicien();
        $technicien-> nom = $nom;
        $technicien-> prenom = $prenom;
        $technicien-> couleur_id = $couleur;
        $technicien-> phone = $phone;
        $technicien-> status_id = $status;
        $technicien-> registre_national = $registre_national;
        $technicien-> rue = $rue;
        $technicien-> numero = $numero;
        $technicien-> code_postal = $codePostal;
        $technicien-> localite = $localite;
        $technicien-> latitude = $technicienCoordinates['latitude'];
        $technicien-> longitude = $technicienCoordinates['longitude'];

        $technicien->save();

        //traitement des relations
        foreach ($regions as $regionId => $priorite) {

            $region = Region::where('id', $regionId)->get();
            $technicien->regions()->attach($region, ['priorite' => $priorite]);

        };

        foreach ($competences as $competence) {
                $comp = Competence::where('id', $competence)->get();
                $technicien->competences()->attach($comp);
        };



        // message comfirm save
        $nomTech = $nom . ' '. $prenom;
        $message = __('Le technicien :nom a été créé avec succès.', [
            'nom' => $nomTech,
        ]);

        return redirect()->route('admin.technicien.index')->with('success', $message);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Technicien $technicien)
    {

        //récup des relations pour constituer les selects
        $couleursOptionsData = ColorTechnicien::where('dispo', 1)->get();
        $status = statusTechnicien::orderBy('nom')->get();
        $regionsOptions = Region::orderBy('name')->get();
        $technicienRegions = $technicien->regions;
        $competencesOptions = Competence::all();
        $technicienCompetences = $technicien->competences->pluck('id')->toArray();

        //dd($technicienRegions[1]);


        return view('admin.technicien.form', [
            'couleursOptionsData' => $couleursOptionsData,
            'technicien' =>$technicien,
            'regionsOptions' => $regionsOptions,
            'technicienRegions' => $technicienRegions,
            'competencesOptions'=> $competencesOptions,
            'technicienCompetences'=> $technicienCompetences,
            'status'=> $status,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technicien $technicien)
    {



        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $phone = $request->input('phone');
        $couleur = $request->input('couleur');

        $registre_national = $request->input('registre_national');
        $rue = $request->input("rue");
        $numero = $request->input('numero');
        $codePostal = $request->input('codePostal');
        $localite = $request->input('localite');
        $status = $request->input('status');
        $regions = $request->input('regions');
        $competences = $request->input('competences');

        if((empty($technicien->latitude) && empty($technicien->longitude)) || $technicien->numero != $numero || $technicien->rue != $rue || $technicien->code_postal != $codePostal || $technicien->localite != $localite){
            $technicienAddress =$numero.' '.$rue. ', '.$codePostal . ' ' . $localite .', Belgique';
            $technicienCoordinates = geocodeAddress($technicienAddress);
            $technicien-> latitude = $technicienCoordinates['latitude'];
            $technicien-> longitude = $technicienCoordinates['longitude'];
        }


        $technicien-> nom = $nom;
        $technicien-> prenom = $prenom;
        $technicien-> couleur_id = $couleur;
        $technicien-> phone = $phone;
        $technicien-> status_id = $status;
        $technicien-> registre_national = $registre_national;
        $technicien-> rue = $rue;
        $technicien-> numero = $numero;
        $technicien-> code_postal = $codePostal;
        $technicien-> localite = $localite;

        $technicien->save();


        $technicienRegion = TechnicienRegion::where('technicien_id', $technicien->id)->get();
        foreach ($technicienRegion as $region) {
            foreach ($regions as $regionId => $priorite) {
                if($region->region_id == $regionId){
                    $region->priorite = $priorite;
                    $region->save();
                }
            }

        }


        $technicien->competences()->sync($competences);


        $message = __('Le contact :nom :prenom a été modifié avec succès.', [
            'nom' => $technicien->nom,
            'prenom' => $technicien->prenom ?? '',
        ]);
        return to_route('admin.technicien.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technicien $technicien)
    {
        \DB::table('technicien_region')->where('technicien_id', $technicien->id)->delete();
        \DB::table('technicien_competence')->where('technicien_id', $technicien->id)->delete();

        $technicien->delete();

        $message = __('Le contact :nom :prenom a été supprimé avec succès.', [
            'nom' => $technicien->nom,
            'prenom' => $technicien->prenom ?? '',
        ]);

        return to_route('admin.technicien.index')->with('success', $message);
    }


    public function searchEventByTechniciens(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;

            if(strstr($search,' ')){
                $searchArray = array();
                foreach(explode(' ',$search) as $word){
                    $searchArray[] = ['nom', 'LIKE', '%'.$word.'%'];
                }

                $data = Technicien::where($searchArray)->get();
            }
            else{

                $data = Technicien::where('nom', 'LIKE', "%$search%")->get();
            }


        }

        return response()->json($data);

    }


    public function techniciensAjax()
    {
        $user = auth()->user();

        $techniciens = Technicien::with('regions', 'competences', 'colorTechnicien', 'user', 'status')->get();

        return response()->json([
            'techniciens' =>$techniciens,
            'user' => $user,

        ], 200);

    }

    public function createAbsenceTechnicien($id)
    {
        $technicien = Technicien::find($id);

        return view('admin.technicien.formAbsence', [
            'technicien' => $technicien
        ]);
    }

    public function storeAbsenceTechnicien(Request $request)
    {
        $technicien = Technicien::find($request->input('technicien_id'));
        $client = Client::where('Codecli', '999999')->first();
        $start = Carbon::parse($request->input('date_debut'));

        $end = Carbon::parse($request->input('date_fin'));
        $startTime = '06:00:00';
        $endTime = '07:00:00';
        $type_event_id = $request->input('motif');
        // nombre de jours de l'absence
        $days = $start->diffInDays($end);
        // boucle sur les jours de l'absence
        for ($i = 0; $i <= $days; $i++) {
            $date = $start->addDays($i);
            $event = new Event();
            $event->start = $date->format('Y-m-d') . ' ' . $startTime;
            $event->end = $date->format('Y-m-d') . ' ' . $endTime;
            $event->type_event_id = $type_event_id;
            $event->client_id = $client->id;
            $event->save();

            $eventTechnicien = new EventTechnicien();
            $eventTechnicien->event_id = $event->id;
            $eventTechnicien->technicien_id = $technicien->id;
            $eventTechnicien->save();
        }
        $technicien->status_id = 5;
        if($type_event_id == 13){
            $technicien->status_id = 2;
        }

        $technicien->save();


        return redirect()->route('admin.technicien.index')->with('success', 'Absence ajoutée avec succès');
    }

//    public function postTechniciensCheckedAjax (Request $request)
//    {
//        $techniciens = [];
//        $techniciens_id = $request->input('techniciensChecked');
//        foreach ($techniciens_id as $technicien_id) {
//            $technicien = Technicien::find($technicien_id);
//
//            $techniciens[] = $technicien;
//
//        }
//
//       return view ('cartography.index', compact('techniciens')); // a voir
//    }
}
