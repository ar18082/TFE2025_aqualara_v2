<?php

namespace App\Http\Controllers;

use App\Models\CodePostelb;
use App\Models\Event;
use App\Models\Technicien;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\false;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class FacturationsController extends Controller
{

    public function index(Request $request)
    {
        $technicien = $request->input('technicien', ''); // Obtenez la valeur de la requête ou une chaîne vide si non définie

        if ($technicien == 0) {
            $events = Event::with('techniciens')
                ->whereYear('start', '=', now()->year)
                ->whereDate('start', '<=', now())
                ->whereNull('facturable')
                ->orderBy('client_id', 'asc')
                ->paginate(25);
        } else {
            $query = Event::with('techniciens')
                ->whereYear('start', '=', now()->year)
                ->whereDate('start', '<=', now())
                ->whereNull('facturable')
                ->orderBy('client_id', 'asc');

            if ($technicien !== '') {
                $query->whereHas('techniciens', function ($query) use ($technicien) {
                    $query->where('techniciens.id', $technicien);
                });
            }

            $events = $query->paginate(25);
        }

        $techniciens = Technicien::all();

        return view('facturations.index', [
            'events' => $events,
            'techniciens' => $techniciens,
        ]);
    }

    public function resultTriAjax(Request $request)
    {


       foreach($request->all() as $value){
           switch ($value['action']) {
               case '1':
                    $event =Event::find($value['id_event']);
                    $event->facturable = 1;
                    $event->save();
                   break;
               case '2':
                   $event = Event::find($value['id_event']);
                   $event->facturable = null;
                   $event->save();
                   // il faut définir une action pour les événements facturables à 2

                   break;
               case '3':
                   $event = Event::find($value['id_event']);
                   $event->facturable = 3;
                   $event->save();
                   $newEvent = $event->replicate();
                   $newEvent-> start = '';
                   $newEvent-> end = '';
                   $newEvent->facturable= null;
                   $newEvent->save();
                   break;

           }
       }

       return response()->json('ok');
    }

    public function listeFacture(Request $request){
        if ($request->has('TypeInter')) {
            if($request->has('TypeInter') == null){
                $typeInter = '';

            }else{
                $typeInter  = $request->input('TypeInter');

            }
        } else {
            $typeInter = '';
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

        if ($request->has('rue')) {
            if($request->has('rue') == null){
                $rue = '';
            }else {
                $rue = $request->input('rue');
            }

        } else {
            $rue = '';
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

        if ($typeInter == ''  && $nom == '' && $rue == '' && $cp_localite == '') {
            $events = Event::with('techniciens')
                ->whereYear('start', '=', now()->year) // Filtrer par année actuelle
                ->where('facturable', 1) // Filtrer par facturable = 1
                ->orderBy('client_id', 'asc')
                ->paginate(25);
        }else {
            $events = Event::with('techniciens')
                ->whereYear('start', '=', now()->year) // Filtrer par année actuelle
                ->where('facturable', 1); // Filtrer par facturable = 1

            if ($typeInter != '') {
                $events->whereHas('typeEvent', function ($query) use ($typeInter) {
                    $query->where('type_event_id', '=', $typeInter);
                });
            }

            if ($nom != '') {
                $events->where('client_id', $nom);
            }

            if ($rue != '') {
                $events->where('client_id', $rue);
            }

            if ($cp_localite != '') {
                $codePost = CodePostelb::find($cp_localite);

                // Si aucun code postal n'est trouvé, vous pouvez choisir de gérer cela
                if (!$codePost) {
                    // Gérer le cas où aucun objet CodePostelb n'est trouvé pour l'ID donné
                    return "Aucun code postal trouvé pour l'ID donné.";
                }

                // Récupérer les clients associés au code postal
                $clients = $codePost->clients()->pluck('clients.id');

                // Récupérer les événements associés à ces clients
                $events->whereIn('client_id', $clients);
            }

            $events = $events->orderBy('client_id', 'asc')->paginate(25);


        }






            return view('facturations.listeFactures', [
                'events' => $events,
            ]);
    }

    public function detailFacture($id)
    {
        $event = Event::find($id);
        $date = now();
        $dateEcheance = now()->addDays(30);



        return view('facturations.form', [
            'event' => $event,
            'date' => $date,
            'dateEcheance' => $dateEcheance,
        ]);
    }

    public function generateFacture(Request $request)
    {



        return redirect()->route('facturation.listeFactures');

    }



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
