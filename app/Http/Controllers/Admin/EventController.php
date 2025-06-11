<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\CodePostelb;

use App\Models\Document;
use App\Models\Event;
use App\Models\EventAppartement;
use App\Models\EventTechnicien;
use App\Models\Technicien;

use App\Models\TypeEvent;
use Carbon\Carbon;
use DateTime;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Date;
use stdClass;


use function Webmozart\Assert\Tests\StaticAnalysis\length;
use function Webmozart\Assert\Tests\StaticAnalysis\null;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EventImport;

use App\Http\Controllers\XmlController;


class EventController extends Controller
{


    public function index(Request $request)
    {

        if ($request->has('TypeInter')) {
            if ($request->has('TypeInter') == null) {
                $typeInter = '';

            } else {
                $typeInter = $request->input('TypeInter');

            }
        } else {
            $typeInter = '';
        }


        if ($request->has('nom')) {
            if ($request->has('nom') == null) {
                $nom = '';
            } else {
                $nom = $request->input('nom');
            }

        } else {
            $nom = '';
        }

        if ($request->has('date')) {
            if ($request->has('date') == null) {
                $date = '';
            } else {
                $date = $request->input('date');
            }

        } else {
            $date = '';
        }

        if ($request->has('cp_localite')) {
            if ($request->has('cp_localite') == null) {
                $cp_localite = '';
            } else {
                $cp_localite = $request->input('cp_localite');
            }

        } else {
            $cp_localite = '';
        }

        if ($typeInter == '' && $nom == '' && $date=='' && $cp_localite == '') {
            $events = Event::with('techniciens')->where('start', '>', date('Y-m-d').' 23:00:00')->orderBy('start', 'asc')->paginate(25);



        } else {
            $events = Event::with('techniciens')->orderBy('client_id', 'asc');


            if ($typeInter != '') {
                $events = $events->whereHas('typeEvent', function ($query) use ($typeInter) {
                    $query->where('type_event_id', '=', $typeInter);
                });

            }

            if ($nom != '') {
                $events = Event::where('client_id', $nom);
            }

            if ($date != '') {

                $events = Event::where('start', 'LIKE', '%'. $date . '%');


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
                $events = Event::whereIn('client_id', $clients)
                    ->with('techniciens')
                    ->orderBy('events.client_id', 'asc');


            }

            $events = $events->paginate(25);

        }


        $nowEvents = Event::with('techniciens')->where('start', 'LIKE', '%'. date('Y-m-d') . '%')->orderBy('start', 'asc')->get();
        $eventsPlanify = Event::with('techniciens')->where('start', '=', '1900-01-01')->orderBy('start', 'asc')->get();


        //dd($nowEvents);

        return view('calendar.event.index', [
            'events' => $events,
            'eventsPlanify' => $eventsPlanify,
            'nowEvents' => $nowEvents,
        ]);
    }

    public function create(Request $request)
    {

        if($request->has('id')){
            $client = Client::find($request->id);
        }else{
            $client = null;
        }

        if (request()->has('client_id')) {
            $client = Client::find(request()->get('client_id'));
        }

        $event = new Event();
        $typeEventsOptions = TypeEvent::where('abreviation', '!=', 'Congé')
            ->where('abreviation', '!=', 'Malade')
            ->where('abreviation', '!=', 'Chômage')
            ->get();
        $techniciensOptions = Technicien::where('status_id', '!=', 2)
            ->where('status_id', '!=', 5)
            ->get();
        $quart = '';


        return view('calendar.event.formEvent', [
            'event' => $event,
            'typeEventsOptions' => $typeEventsOptions,
            'techniciensOptions' => $techniciensOptions,
            'client' => $client,
            'quart' => $quart,
        ]);
    }

    public function store(Request $request)
    {

        
        $request->validate([
            'client_id' => 'required',
            'startDate' => 'required',
            'typeIntervention' => 'required',
            'quart' => 'required',

        ], [
            'client_id.required' => 'Le client est obligatoire.',
            'startDate.required' => 'La date de l\'événement est obligatoire.',
            'typeIntervention.required' => 'Le type d\'intervention est obligatoire.',
            'quart.required' => 'Le quart est obligatoire.',
        ]);


        // il faut aller consulter dans le client si on a les infos sur le materiel
        // si on a les infos sur le materiel on peut récupérer le temps d'intervention selon le type d'intervention. Si on a pas les infos sur le materiel on peut mettre un temps d'intervention par défaut

        // priorité 1 : temps par défaut 30 min
        // priorité 2 : temps repris dans la table matériel
        // priotité 3 : temps repris dans l'input si > 30 min



        $client_id = $request->client_id;
        $typeIntervention = $request->typeIntervention;
        $quart = $request->quart;
        $time = $request->time;
        $commentaire = $request->commentaire;
        $techniciens = $request->techniciens;
        $appartements = $request->appartement;


        // check if the materiel has in relation with appareils for time of intervention
        $client = Client::where('id', $request->client_id)
            ->with('appareils.materiel')
            ->with('codePostelbs')
            ->with('appartements')
            ->with('clichaufs')
            ->with('cliEaus')
            ->first();


        foreach ($client->appareils as $appareil) {
            if ($appareil->materiel) {
                switch ($typeIntervention){
                    case 1: // rg
                        if($appareil->materiel->tps_RG){
                            $time = $appareil->materiel->tps_RG;
                        }
                        break;
                    case 5: // rplt
                        if($appareil->materiel->tps_rplt){
                            $time = $appareil->materiel->tps_rplt;
                        }
                        break;
                    case 6: // plt
                        if($appareil->materiel->tps_plt){
                            $time = $appareil->materiel->tps_plt;
                        }
                        break;

                }

            }
        }

        //traitement date + hour
        $startTime = '08:30:00';
        if($quart == 'PM'){
            $startTime = '12:30:00';
        }

        $start = $request->startDate . ' ' . $startTime;
        $endTime = Carbon::createFromFormat('H:i:s', $startTime)->addMinutes($time)->format('H:i:s');
        $end = $request->endDate . ' ' . $endTime;



        $event = new Event();
        $event->client_id = $client_id;
        $event->type_event_id = $typeIntervention;
        $event->date = $request->startDate;
        $event->start = $start;
        $event->end = $end;
        $event->commentaire = $commentaire;
        $event->quart = $quart;
        $event->save();

        $client = Client::where('id', $client_id)->with('codePostelbs')->first();
        // check if the client has latitude and longitude for marker on the map
        if ($client->latitude == null && $client->longitude == null) {

            $address = $client->rue . ', ' . $client->codepost . ' ' . $client->codePostelbs[0]->Localite . ',' . $client->codePostelbs[0]->CodePays;

            $coordinates = geocodeAddress($address);
            if ($coordinates) {

                $client->latitude = $coordinates['latitude'];
                $client->longitude = $coordinates['longitude'];
                $client->save();

            }
        }

        if($techniciens){

            foreach ($techniciens as $technicien) {
                $eventTechnicien = new EventTechnicien();
                $eventTechnicien->event_id = $event->id;
                $eventTechnicien->technicien_id = $technicien;
                $eventTechnicien->save();
            }
        }



        if($appartements != null && count($appartements) > 0){
            foreach ($appartements as $appartement) {
                $eventAppartement = new EventAppartement();
                $eventAppartement->event_id = $event->id;
                $eventAppartement->appartement_id = $appartement;
                $eventAppartement->save();
            }
        }

        $typeEvent = TypeEvent::where('id', $typeIntervention)->first();


        //créer un bon de route, un avis de passage et si radio un fichier xml
        $startFormatted = $request->startDate;

        // j'aimerais générer ces fichiers en arrière plan afin de ne pas bloquer la page 
        downloadPDF($client->id, 'Bon', $startFormatted);
        downloadPDF($client->id, 'Avis', $startFormatted);
        downloadPDF($client->id, 'FicheRep', $startFormatted);
        // verifier si releve radio et si oui générer le fichier xml
            if($client->clichaufs->count() > 0){
                if($client->clichaufs->first()->TypRlv == 'RADIO' || $client->cliEaus->first()->TypRlv == 'RADIO'){
                   // appeler generateXml
                    $xmlController = new XmlController();
                    $xmlController->generateXml($event);
                }
            }



        $message = __(':typeInter pour :nom le :date a été créé avec succès.', [
            'nom' => $client->nom,
            'typeInter' => $typeEvent->name,
            'date' => $start,
        ]);

        return back()->with('success', $message);
    }

    public function appartementsAjax ($id)
    {
        $client = Client::find($id);
        $appartements = $client->appartements;

        return response()->json($appartements);
    }

    public function edit(Event $event)
    {

        $client = $event->client;
        $typeEventsOptions = TypeEvent::all();
        $techniciensOptions = Technicien::all();

        $start = $event->start;
        $end = $event->end;
        $startHour = explode(' ', substr($start, 11))[0];
        $endHour = explode(' ', substr($end, 11))[0];

        if ($startHour == '08:30:00' && $endHour == '17:00:00') {
            $quart = 'allDay';
        } elseif ($endHour <= '12:30:00') {
            $quart = 'AM';
        } else {
            $quart = 'PM';
        }


        return view('calendar.event.formEvent', [
            'event' => $event,
            'client' => $client,
            'typeEventsOptions' => $typeEventsOptions,
            'techniciensOptions' => $techniciensOptions,



        ]);
    }

    private function updateEvent(array $data, $event)
    {
            //dd($data);


        $client_id = $data['client_id'];
        $typeIntervention = $data['typeIntervention'];
        $start = $data['startDate'] . ' ' . $data['startTime'];


        $end = $data['startDate'] . ' ' . $data['endTime'];
        $startFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $startFormatted = $startFormatted->format('Y-m-d H:i');
        $endFormatted = Carbon::createFromFormat('Y-m-d H:i:s', $end);
        $endFormatted = $endFormatted->format('Y-m-d H:i');
        $commentaire = $data['commentaire'];
        $techniciens = $data['techniciens'];
        $appartements = $data['appartement']?? null;

        $client = Client::where('id', $client_id)->first();
        $codePostelb = CodePostelb::where('codepost', $client->codepost)->first();

        $event->client_id = $client_id;
        $event->type_event_id = $typeIntervention;
        $event->start = $startFormatted;
        $event->end = $endFormatted;
        $event->commentaire = $commentaire;

        if ($client->latitude == null && $client->longitude == null) {
            $address = $client->rue . ', ' . $client->codepost . ' ' . $codePostelb->Localite . ',' . $codePostelb->CodePays;
            $coordinates = geocodeAddress($address);
            if ($coordinates) {

                $client->latitude = $coordinates['latitude'];
                $client->longitude = $coordinates['longitude'];
                $client->save();

            }
        }

        $event->save();

        $event->techniciens()->detach();

        foreach ($techniciens as $technicien) {
            $eventTechnicien = new EventTechnicien();
            $eventTechnicien->event_id = $event->id;
            $eventTechnicien->technicien_id = $technicien;
            $eventTechnicien->save();
        }

        $eventAppartements = $event->eventAppartements()->get();
        $eventAppartements->each->delete();

        if($appartements != null && count($appartements) > 0){
            foreach ($appartements as $appartement) {

                $eventAppartement = new EventAppartement();
                $eventAppartement->event_id = $event->id;
                $eventAppartement->appartement_id = $appartement;
                $eventAppartement->save();

            }
        }

        $client = Client::where('id', $client_id)->first();
        $typeEvent = TypeEvent::where('id', $typeIntervention)->first();

        $date = Carbon::parse($start);

        $documents = Document::where('client_id', $client_id)
            ->where('send_at', $startFormatted)
            ->where('link', 'like', '%' . $client->nom . '%')
            ->get();

        if ($documents) {
            foreach ($documents as $document) {
                $document->send_at = $start;
                $document->save();
            }

        }

        //créer un bon de route et un avis de passage

        downloadPDF($client->id, 'Bon', $startFormatted);
        downloadPDF($client->id, 'Avis', $startFormatted);
        downloadPDF($client->id, 'FicheRep', $startFormatted);



        $client = Client::where('id', $client_id)->first();
        $typeEvent = TypeEvent::where('id', $typeIntervention)->first();

        $date = Carbon::parse($start);

        $message = __(' :typeInter pour :nom le :date a été modifié avec succès.', [
            'nom' => $client->nom,
            'typeInter' => $typeEvent->name,
            'date' => $date,
        ]);

        return $message;

    }

    public function update(Request $request, Event $event)
    {


        $request->validate([
            'client_id' => 'required',
            'startDate' => 'required',
            'typeIntervention' => 'required',
            'quart' => 'required',

        ], [
            'client_id.required' => 'Le client est obligatoire.',
            'startDate.required' => 'La date de l\'événement est obligatoire.',
            'typeIntervention.required' => 'Le type d\'intervention est obligatoire.',
            'quart.required' => 'Le quart est obligatoire.',
        ]);

        $client = Client::find($request->client_id);
        $event->load('typeEvent');

        $date = carbon::parse($event->start)->format('d-m-Y');

        $message = __(':typeInter pour :nom le :date a été créé avec succès.', [
            'nom' => $client->nom,
            'typeInter' => $event->typeEvent->name,
            'date' => $date,
        ]);
        return to_route('immeubles.show', $client->Codecli)->with('success', $message);

    }

    public function destroy(Event $event)
    {
        $client = Client::where('id', $event->client_id)->first();
        $typeIntervention = TypeEvent::where('id', $event->type_event_id)->first();

        $nom = $client->nom;
        $intervention = $typeIntervention->name;
        $date = $event->start;
        $date = Carbon::parse($date)->format('Y-m-d');

        $event->delete();

        $documents = Document::where('client_id', $client->id)
            ->where('send_at', $date)
            ->where('link', 'like', '%' . $client->nom . '%')
            ->get();


        foreach ($documents as $document) {
            if (Storage::exists($document->link)) {
                Storage::delete($document->link);
                $document->delete();
            }
        }


        $message = __('Le :typeInter le :date pour :nom a été supprimé avec succès.', [
            'nom' => $nom,
            'typeInter' => $intervention,
            'date' => $date,

        ]);

        return to_route('immeubles.show', $client->Codecli)->with('success', $message);
    }

    public function validateEvent(Request $request)
    {
        $event = Event::where('client_id', $request->input('client_id'))
            ->whereDate('start', date('Y-m-d'))
            ->first();
        $event->valide = true;
        $event->save();

        return back();
    }

    private function createEvent($typeIntervention, $eventTypeToCheck)
    {
        $today = new DateTime();
        $yesterday = $today->modify('-1 day')->format('Y-m-d');
        $events = Event::whereDate('end', $yesterday)->get();

        $nbNewEvent = 0;
        $messages = '';

        foreach ($events as $event) {
            if ($event->type_event_id == $eventTypeToCheck) {
                $client_id = $event->client_id;
                $commentaire = $event->commentaire;

                $appartements_for_count = Appartement::with('Absent')
                    ->where('Codecli', $client_id)->get();

                $nbImmAbsent = 0;

                foreach ($appartements_for_count as $appartement) {
                    if ($appartement->Absent->count() > 0) {
                        if ($appartement->Absent->first()->is_absent) {
                            $nbImmAbsent++;
                        }
                    }
                }

                if ($nbImmAbsent > 0) {
                    $newEvent = new Event();
                    $newEvent->client_id = $client_id;
                    $newEvent->type_event_id = $typeIntervention;
                    $newEvent->commentaire = $typeIntervention . ' passage : ' . $nbImmAbsent . ' absents   ' . $commentaire;

                    $newEvent->save();

                    foreach ($event->techniciens as $technicien) {
                        $eventTechnicien = new EventTechnicien();
                        $eventTechnicien->event_id = $newEvent->id;
                        $eventTechnicien->technicien_id = $technicien->id;
                        $eventTechnicien->save();
                    }
                    $nbNewEvent++;
                }
            }
        }
        if($nbNewEvent > 0){
            $messages = $nbNewEvent . ' évenement(s) "' . $typeIntervention . ' passage" ont été créés avec succès.';
        } else {
            $messages = 'Aucun évènement de type "' . $typeIntervention . ' passage" à créer.';
        }


        return to_route('admin.event.index')->with('success', $messages);
    }

    public function eventSecondPassage()
    {
        // 1. Récupérer les événements de type "relevé généraux" de la journée précédente.
        $hier = Carbon::yesterday()->format('Y-m-d');
        $evenementsReleveGeneraux = Event::where('type_event_id', 1)
        ->whereDate('start', $hier)
            ->get();

        // Parcourir chaque événement
        foreach ($evenementsReleveGeneraux as $evenement) {
            // 2. Vérifier si le client associé a des appartements marqués comme absents.
            $appartementsAbsents = Appartement::where('client_id', $evenement->client_id)
                ->where('is_absent', 1) // en supposant que 'is_absent' est le champ pertinent
                ->count();

            // 3. S'il y a des appartements absents, créer un nouvel événement de type "2eme passage" pour ce client.
            if ($appartementsAbsents > 0) {
                $nouvelEvenement = new Event();
                $nouvelEvenement->client_id = $evenement->client_id;
                $nouvelEvenement->type_event_id = 11;

                // 4. Attribuer le même technicien au nouvel événement.
                $technicienEvenement = EventTechnicien::where('event_id', $evenement->id)->first();
                $nouveauTechnicienEvenement = new EventTechnicien();
                $nouveauTechnicienEvenement->technicien_id = $technicienEvenement->technicien_id;

                // 5. Définir la date du nouvel événement à une valeur par défaut de "1900-1-1".
                $nouvelEvenement->start = Carbon::create(1900, 1, 1, 0, 0, 0);
                $nouvelEvenement->end = Carbon::create(1900, 1, 1, 1, 0, 0);

                // Enregistrer le nouvel événement et le nouveau technicien de l'événement
                $nouvelEvenement->save();
                $nouveauTechnicienEvenement->event_id = $nouvelEvenement->id;
                $nouveauTechnicienEvenement->save();
            }
        }
    }

    public function eventTroisiemePassage()
    {

        $hier = Carbon::yesterday()->format('Y-m-d');
        $evenementsReleveGeneraux = Event::where('type_event_id', 11)
            ->whereDate('start', $hier)
            ->get();

        // Parcourir chaque événement
        foreach ($evenementsReleveGeneraux as $evenement) {
            // 2. Vérifier si le client associé a des appartements marqués comme absents.
            $appartementsAbsents = Appartement::where('client_id', $evenement->client_id)
                ->where('is_absent', 1) // en supposant que 'is_absent' est le champ pertinent
                ->count();

            // 3. S'il y a des appartements absents, créer un nouvel événement de type "2eme passage" pour ce client.
            if ($appartementsAbsents > 0) {
                $nouvelEvenement = new Event();
                $nouvelEvenement->client_id = $evenement->client_id;
                $nouvelEvenement->type_event_id = 10;

                // 4. Attribuer le même technicien au nouvel événement.
                $technicienEvenement = EventTechnicien::where('event_id', $evenement->id)->first();
                $nouveauTechnicienEvenement = new EventTechnicien();
                $nouveauTechnicienEvenement->technicien_id = $technicienEvenement->technicien_id;

                // 5. Définir la date du nouvel événement à une valeur par défaut de "1900-1-1".
                $nouvelEvenement->start = Carbon::create(1900, 1, 1, 0, 0, 0);
                $nouvelEvenement->end = Carbon::create(1900, 1, 1, 1, 0, 0);

                // Enregistrer le nouvel événement et le nouveau technicien de l'événement
                $nouvelEvenement->save();
                $nouveauTechnicienEvenement->event_id = $nouvelEvenement->id;
                $nouveauTechnicienEvenement->save();
            }
        }
    }

    public function eventAjax()
    {

        $startDate = now()->startOfMonth(); // Début du mois en cours
        $endDate = now()->addMonths(4)->endOfMonth();



        if (Auth::check() && Auth::user()->role === 'admin') {

            $datasEvents = Event::whereBetween('start', [$startDate, $endDate])->with('client', 'client.appartements', 'client.cliEaus', 'client.clichaufs', 'client.appareils', 'techniciens', 'techniciens.colorTechnicien', 'eventAppartements', 'typeEvent' )->get();

        }else {

            $technicianId = 17;
            $datasEvents = Event::whereHas('techniciens', function ($query) use ($technicianId) {
                $query->where('event_technicien.technicien_id', $technicianId);
            })
                ->whereBetween('start', [$startDate, $endDate])
                ->with('client', 'client.appartements', 'client.cliEaus','client.appareils', 'client.clichaufs', 'client.relChaufApps',
                    'client.relEauApps', 'techniciens', 'techniciens.colorTechnicien', 'eventAppartements', 'typeEvent' )
                ->get();


//            dd($datasEvents);
        }


        return response()->json($datasEvents);
    }

    public function eventAjaxNoDate ()
    {
        $events = Event::where('start', null)->with('client', 'client.appartements', 'techniciens', 'techniciens.colorTechnicien', 'eventAppartements', 'typeEvent')->get();

        return response()->json($events);
    }

    public function searchEventByTypInter(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;

            if (strstr($search, ' ')) {
                $searchArray = array();
                foreach (explode(' ', $search) as $word) {
                    $searchArray[] = ['name', 'LIKE', '%' . $word . '%'];
                }

                $data = TypeEvent::where($searchArray)->get();
            } else {

                $data = TypeEvent::where('name', 'LIKE', "%$search%")->get();
            }


        }

        return response()->json($data);

    }

    public function updateTimeEventAjax(Request $request)
    {

        $eventId =$request['datas']['id'];
        $newStartDate = date('Y-m-d H:i:s', strtotime($request['datas']['start']));
        $newEndDate = date('Y-m-d H:i:s', strtotime($request['datas']['end']));

        $event = Event::find($eventId)->first();

        if($event != null) {

            $event->update(['start' => $newStartDate, 'end' => $newEndDate]);
            $event->save();

            return response()->json(['message' => 'Événement mis à jour avec succès'], 200);

        } else {

            return response()->json(['message' => 'Event non trouvé'], 200);
        }




    }

    public function updateEventAjax(Request $request)
    {
        $event = Event::find($request['datas']['id'])->with('techniciens', 'eventAppartements', 'client', 'client.appartements',  'typeEvent', 'techniciens.colorTechnicien')->get();

        dd($event);



        return response()->json(['message' => 'OK'], 200);

    }

    public function UpdateAllDay(Request $request)
    {
        $startDate = $request->input('startDate');
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $newDate = $request->input('newDate');
        $newDate = Carbon::createFromFormat('Y-m-d', $newDate);
        $techniciens = $request->input('techniciens');

        $events = Event::whereDate('start', $startDate)->get();


        foreach ($events as $event) {
            // Update start date
            $eventStartDate = Carbon::createFromFormat('Y-m-d H:i:s', $event->start);
            $newStartDate = $newDate->format('Y-m-d') . ' ' . $eventStartDate->format('H:i:s');
            $event->start = $newStartDate;

            // Update end date
            if (!empty($event->end)) {
                $eventEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $event->end);
                $newEndDate = $newDate->format('Y-m-d') . ' ' . $eventEndDate->format('H:i:s');
                $event->end = $newEndDate;
            }

            // Save the changes to the event
            $event->save();

            $event->techniciens()->detach();
            $event->techniciens()->attach($techniciens);
        }


        return response()->json(['success' => true, 'message' => 'Données enregistrées avec succès'], 200);
    }

    public function ordreEvent(Request $request)
    {

        dd($request->all());

        $event = Event::where('id', $request->eventId)->first();
        $start = $request->date . ' ' . $request->heure;
        $end = Carbon::parse($start)->addMinutes($request->duree)->format('Y-m-d H:i:s');

        $event->start = $start;
        $event->end = $end;
        $event->save();

        $eventTechnicien = EventTechnicien::where('event_id', $request->eventId)
            ->where('technicien_id', $request->technicien)
            ->get();

        if($eventTechnicien->count() == 0){
            $eventTechnicien = new EventTechnicien();
            $eventTechnicien->event_id = $request->eventId;
            $eventTechnicien->technicien_id = $request->technicien;
            $eventTechnicien->save();
        }

        return response()->json([
            'response' => 'Données enregistrées avec succès',
        ], 200);

    }

    public function ShowEventImmeublesAjax(Request $request)
    {

       // tous les events with client dont client.Codecli = $request->id
        $events = Event::whereHas('client', function ($query) use ($request) {
            $query->where('Codecli', $request->id);
        })
            ->with('client', 'client.appartements', 'client.cliEaus', 'client.clichaufs', 'client.appareils', 'techniciens', 'techniciens.colorTechnicien', 'eventAppartements', 'typeEvent' )
            ->get();


        return response()->json($events);
    }

    public function eventTimelineAjax(Request $request)
    {





        return response()->json(['response' => 'ok'], 200);

    }


}
