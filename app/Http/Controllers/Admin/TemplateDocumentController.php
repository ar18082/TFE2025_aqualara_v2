<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientExport;
use App\Http\Controllers\Controller;
use App\Imports\ClientsImport;
use App\Models\AvisPassageText;
use App\Models\Client;
use App\Models\CodePostelb;
use App\Models\Document;
use App\Models\Event;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\Technicien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;
use function Webmozart\Assert\Tests\StaticAnalysis\length;
use function Webmozart\Assert\Tests\StaticAnalysis\true;
use Barryvdh\DomPDF\Facade\Pdf;

class TemplateDocumentController extends Controller
{

    public function listeDocument($type)
    {

        $title = '';
        switch ($type) {
            case 'Bon':
                $title = 'Liste des bons de route';
                $typeComplet = 'Bon de route';
                break;
            case 'Avis':
                $title = 'Liste d\'avis de passage';
                $typeComplet = 'Avis de passage';
                break;
            case 'Rapport':
                $title = 'Liste des rapports';
                $typeComplet = 'Rapport';
                break;

        }

        $documents = Document::where('type', $typeComplet)
            ->with('event.techniciens')
            ->get();

        $techniciens = Technicien::all();

        return view('documents.templateDocument.listeDocument', [
            'title' => $title,
            'documents' => $documents,
            'type' => $type,
            'techniciens' => $techniciens,
        ]);
    }

    public function searchDocument($type, Request $request)
    {

        $title = '';
        switch ($type) {
            case 'Bon':
                $title = 'Liste des bons de route';
                $typeComplet = 'Bon de route';
                break;
            case 'Avis':
                $title = 'Liste d\'avis de passage';
                $typeComplet = 'Avis de passage';
                break;
            case 'Rapport':
                $title = 'Liste des rapports';
                $typeComplet = 'Rapport';
                break;

        }

        if($request->has('client_id') && $request->input('date') != null){
            $documents = Document::where('type', $typeComplet)
                ->where('client_id', $request->input('client_id'))
                ->with(['event' => function($query) use ($request) {
                    $query->where('start', 'like', '%' . $request->input('date') . '%')->with('techniciens');
                }])
                ->get();
        }elseif($request->has('client_id') && $request->input('date') == null ){
            $documents = Document::where('type', $typeComplet)
                ->where('client_id', $request->input('client_id'))
                ->with('event.techniciens')
                ->get();
        }elseif(!$request->has('client_id') && $request->input('date') != null) {
            $documents = Document::where('type', $typeComplet)
                ->with(['event' => function ($query) use ($request) {
                    $query->where('start', 'like', '%' . $request->input('date') . '%')->with('techniciens');
                }])
                ->get();
        }else{
            $documents = Document::where('type', $typeComplet)
                ->with('event.techniciens')
                ->get();
        }

        $techniciens = Technicien::all();

        return view('documents.templateDocument.listeDocument', [
            'title' => $title,
            'documents' => $documents,
            'type' => $type,
            'techniciens' => $techniciens,
        ]);

    }


    public function editRapport($id)
    {
        if($id == 0){
            $client = new Client();
        }else{
            $client = Client::where('id', $id)
                ->with('appartements')
                ->with('codePostelbs')
                ->with('clichaufs')
                ->with('cliEaus')
                ->with('relChaufApps')
                ->with('relEauApps')
                ->with('appartements.notesAppartements')
                ->with('events.typeEvent')
                ->first();
        }


        $view = 'documents.templateDocument.formRapport';
        return view($view, [
            'client' => $client,
        ]);

    }

    public function createRapport(Request $request)
    {
        if($request->input('client_id') != null) {

            $client = Client::where('id', $request->input('client_id'))
                ->with('appartements')
                ->with('codePostelbs')
                ->with('clichaufs')
                ->with('cliEaus')
                ->with('relChaufApps')
                ->with('relEauApps')
                ->with('appartements.notesAppartements')
                ->with('events')
                ->first();

        }else{

            // récupérer les données du formulaire
            $clientName = $request->input('clientName');
            $clientRue = $request->input('clientRue');
            $clientCodePost = $request->input('clientCodePost');
            $clientLocalite = $request->input('clientLocalite');
            $clientTel = $request->input('clientTel');

            $gerant = $request->input('gerant');
            $codecli = $request->input('codecli');
            $rueger = $request->input('rueger');
            $telger = $request->input('telger');
            $email = $request->input('email');


            $client = Client::where('Codecli', $codecli)
                ->with('appartements')
                ->with('codePostelbs')
                ->with('clichaufs')
                ->with('cliEaus')
                ->with('relChaufApps')
                ->with('relEauApps')
                ->with('appartements.notesAppartements')
                ->with('events')
                ->first();

            $client->nom = $clientName;
            $client->rue = $clientRue;
            $client->codepost = $clientCodePost;
            $client->codePostelbs[0]->Localite = $clientLocalite;
            $client->tel = $clientTel;
            // $date doit etre assigné à quoi ?
            $client->gerant = $gerant;
            $client->Codecli = $codecli;
            $client->rueger = $rueger;
            $client->telger = $telger;
            $client->Email = $email;

        }

       $client->save();

        $date = $request->input('date');
        $devisNbApp = $request->input('devisNbApp');
        $devisNbRFC = $request->input('devisNbRFC');
        $devisNbCptEau = $request->input('devisNbCptEau');
        $devisNbInteg = $request->input('devisNbInteg');
        $devisAntiRetour = $request->input('devisAntiRetour');
        $devisTelereleve = $request->input('devisTelereleve');
        $appTermine = $request->input('appTermine');
        $rfcInstalles = $request->input('RFCinstalles');
        $rfcInstallesSondes = $request->input('RFCinstallesSondes');
        $cptEauC = $request->input('cptEauC');
        $cptEauF = $request->input('cptEauF');
        $integrateurs = $request->input('integrateurs');
        $anti_retour = $request->input('anti-retour');
        $nbrVisites = $request->input('nbrVisites');
        $nbrVidanges = $request->input('nbrVidanges');
        $startWork = $request->input('startWork');
        $endWork = $request->input('endWork');

        $client->relChaufApps[0]->NbRad = $devisNbApp;
        $client->relEauApps[0]->NbCptChaud = $devisNbRFC;
        $client->relEauApps[0]->NbCptFroid = $devisNbCptEau;

        $event = Event::where('client_id', $client->id)
            ->where('start', 'like', '%'. $startWork .'%')
            ->first();



        // create a object $devis
        $devis = (object) [
            'devisNbApp' => $devisNbApp,
            'devisNbRFC' => $devisNbRFC,
            'devisNbCptEau' => $devisNbCptEau,
            'devisNbInteg' => $devisNbInteg,
            'devisAntiRetour' => $devisAntiRetour,
            'devisTelereleve' => $devisTelereleve,
        ];

        $execution = (object)[
            'appTermine' => $appTermine,
            'rfcInstalles' => $rfcInstalles,
            'rfcInstallesSondes' => $rfcInstallesSondes,
            'cptEauC' => $cptEauC,
            'cptEauF' => $cptEauF,
            'integrateurs' => $integrateurs,
            'anti_retour' => $anti_retour,
            'nbrVisites' => $nbrVisites,
            'nbrVidanges' => $nbrVidanges,
            'startWork' => $startWork,
            'endWork' => $endWork,
        ];

        $data = [
            'client' => $client,
            'devis' => $devis,
            'execution' => $execution,
        ];


        $view = 'documents.templateDocument.viewRapport';

        $pdf = Pdf::loadView($view, $data);

        $content = $pdf->output();

        $date = Carbon::parse($date)->toDateString();
        $date = str_replace('-', '', $date);
        $link = 'storage/documents/';
        $filename = 'Rapport-'.$client->Codecli.'-'.$date.'.pdf';

        $document = Document::where('client_id', $client->id)
            ->where('type', 'Rapport')
            ->where('link', $link.$filename)
            ->first();

        if($document == null){
            $document = new Document();
            $document->client_id = $client->id;
            $document->type = 'Rapport';
            $document->link = $link.$filename;
            $document->event_id = $event->id;
            $document->save();
        }

        Storage::put($link.$filename, $content);


        // return route immeubles.show  with success message
        return redirect()->route('immeubles.show', $client->Codecli)
            ->with('success', 'Rapport généré avec succès.');

    }

    public function showRapport($id)
    {
        $document = Document::where('client_id', $id)
            ->where('type', 'Rapport')
            ->first();
        //dd($document);
        // afficher le fichier pdf  dans le navigateur

        $file = Storage::get($document->link);

        return response($file, 200)
            ->header('Content-Type', 'application/pdf');

    }


    public function deleteRapport($id, $created_at)
    {
        // supprimer le fichier pdf
        $document = Document::where('client_id', $id)
            ->where('type', 'Rapport')
            ->where('created_at', $created_at)
            ->first();
        $document->delete();

        // remove the file from storage
        Storage::delete($document->link);

        return redirect()->back()
            ->with('success', 'Rapport supprimé avec succès.');
    }

    public function showDocument($id){
        $document = Document::where('id', $id)
            ->first();

        $file = Storage::get($document->link);

        // afficher le fichier pdf  dans le navigateur
        return response($file, 200)
            ->header('Content-Type', 'application/pdf');



    }

    public function editDocument($id)
    {
        // récupere l'url de la page précédente
        $url = url()->previous();

        $document = Document::where('id', $id)
            ->with('event.techniciens.colorTechnicien')
            ->with('client.codePostelbs')
            ->with('client.clichaufs')
            ->with('client.cliEaus')
            ->first();

        if($document->type == 'Bon de route'){

            $view = 'documents.templateDocument.formBonRoute';
            $techniciens = Technicien::with('colorTechnicien')
                ->whereHas('status', function($query) {
                    $query->where('nom', '!=',  'Arret maladie')
                        ->where('nom', '!=',  'Inactif');

                })
                ->get();


            $data = [
                'event' => $document->event,
                'techniciens' => $techniciens,
                'type' => $document->type,
                'url' => $url,
            ];



        }elseif($document->type == 'Avis de passage'){



            if(($document->client->clichaufs->count() > 0 && $document->client->clichaufs->first()->TypRlv == 'VISU')|| ($document->client->cliEaus->count() > 0 && $document->client->cliEaus->first()->TypRlv == 'VISU')){

                $avisPassageText = AvisPassageText::where('type_event_id', $document->event->type_event_id)
                    ->where('TypRlv', 'VISU')
                    ->first();
            }else{

                $avisPassageText = AvisPassageText::where('type_event_id', $document->event->type_event_id)
//                    ->where('TypRlv', 'RADIO/GPRS')
                    ->first();


            }

            $data = [
                'event' => $document->event,
                'avisPassageText' => $avisPassageText,
                'localite' => $document->client->codePostelbs[0]->Localite,
                'type' => $document->type,
                'url' => $url,
            ];

            $view = 'documents.templateDocument.formAvisPassage';


        }

        return view($view, $data);

    }

    public function updateDocument(Request $request)
    {
        $datas = $request->all();

        $event = Event::where('id', $datas['event_id'])
            ->with('techniciens')
            ->with('client')
            ->with('typeEvent')
            ->with('document')
            ->first();

        switch ($datas['type']){
            case 'Bon de route' :

               // update eventTechnicien
               $event->techniciens[0]->pivot->technicien_id = intval($datas['techniciens']);
               $event->techniciens[0]->pivot->save();

               // update event
               $event->start = $datas['dateEvent']. ' ' . $datas['startTime'].':00';
               $event->end = $datas['dateEvent']. ' ' . $datas['endTime'].':00';
               $event->type_event_id = intval($datas['type_intervention']);
               $event->commentaire = $datas['specifique'];
               $event->save();

                // update client remarque
               $event->client->remarque = $datas['permanantes'];
               $event->client->save();

                // update document
                $document = $event->document()->where('type', $datas['type'])->first();
                $filename = $document->link;
                $view = 'documents.templateDocument.viewBonRoute';

                $data = [
                    'event' => $event,
                    'localite' => $event->client->codePostelbs[0]->Localite,
                ];

                break;
            case 'Avis de passage' :

                 // il faut que je recupère le fichier pdf et que je le mette à jour
                $document = $event->document()->where('type', $datas['type'])->first();
                $filename = $document->link;
                $view = 'documents.templateDocument.viewAvisPassage';

                $avisPassageText = (object) [
                    'typePassage' => $datas['typePassage'],
                    'acces' => $datas['acces'],
                    'presence' => $datas['presence'],
                    'coupure' => $datas['coupure'],
                ];


                $data = [
                    'event' => $event,
                    'avisPassageText' => $avisPassageText,
                    'localite' => $document->client->codePostelbs[0]->Localite,
                ];


                break;
        }

        $pdf = Pdf::loadView($view, $data);
        $content = $pdf->output();

        Storage::put($filename, $content);
        $pdf->download($filename);

        return redirect()->back()->with('success', 'Document mis à jour avec succès.');

    }

    public function deleteDocument($id)
    {
        $document = Document::where('id', $id)->first();
        $document->delete();

        Storage::delete($document->link);

        return redirect()->back()
            ->with('success', 'Document supprimé avec succès.');
    }


    public function feuilleFrais()
    {
        $event = Event::where('client_id', '1')
            ->with('client.cliEaus')
            ->with('client.clichaufs')
            ->with('client.codePostelbs')
            ->with('client.gerantImms.contacts')
            ->with('typeEvent')
            ->orderBy('start', 'desc')
            ->first();

        $client = $event->client;
        $localite = CodePostelb::where('codePost', $client->codepost ?? $client->codepostger)->first()->Localite;
        $localiteGer = CodePostelb::where('codePost', $client->codepostger)->first()->Localite;
        $avisPassageText = '';

        $data = [
            'event' => $event,
            'localite' => $localite,
            'localiteGer' => $localiteGer,
            'btnReturn' => false,
            'avisPassageText' => $avisPassageText,
        ];

        $formattedDate = Carbon::parse($event->start)->format('Y');


        $view = 'documents.templateDocument.viewFeuilleFraisFR';

        $pdf = Pdf::loadView($view, $data);
        return $pdf->stream('FeuilleFrais.pdf');
    }


    public function downloadPdfBonDeRoute($id)
    {

        $document = Document::find($id);
        $event = Event::where('client_id',$document->client_id)->first();


        if (!$event) {
            abort(404, 'Event not found');
        }

        $client = $event->client;
        $localite = CodePostelb::where('codePost', $client->codepost?? $client->codepostger)->first();



        if (!$client) {
            abort(404, 'Client not found');
        }

        $data = [
            'event' => $event,
            'localite' => $localite->Localite,
            'btnReturn' => false,
        ];


        $pdf = Pdf::loadView('documents.templateDocument.viewBonRoute', $data);

        return $pdf->download($document->link);

    }

    public function BonDeRouteAjax(Request $request)
    {
        $datas = $request->all();

        $events = Event::whereBetween('start', [$datas['dateDebut'], $datas['dateFin']])
            ->get();

        if ($events->isNotEmpty()) {
            foreach ($events as $event) {
                $event->valide = true;
                $event->save();
            }
        } else {
            // Aucun événement trouvé pour la date spécifiée
            dd('Aucun événement trouvé pour la date spécifiée.');
        }

        return response()->json($datas);
    }



    public function downloadPdfAvisDePassage($id)
    {


        $document = Document::find($id);

        $event = Event::where('client_id',$document->client_id)->first();
        if (!$event) {
            abort(404, 'Event not found');
        }

        $client = $event->client;


        if (!$client) {
            abort(404, 'Client not found');
        }

        if(($client->clichaufs->count() > 0 && $client->clichaufs->first()->TypRlv == 'VISU')|| ($client->cliEaus->count() > 0 && $client->cliEaus->first()->TypRlv == 'VISU')){
            $avisPassageText = AvisPassageText::where('type_event_id', $event->type_event_id)
                ->where('TypRlv', 'VISU')
                ->first();
        }else{
            $avisPassageText = AvisPassageText::where('type_event_id', $event->type_event_id)
                ->where('TypRlv', 'RADIO/GPRS')
                ->first();
        }

        // Définir la locale française
        Carbon::setLocale('fr');

//        // Convertir et formater la date
//        $date = Carbon::parse($event->start)->isoFormat('dddd D MMMM YYYY');

        $localite = CodePostelb::where('codePost', $client->codepost)->first();

        $data = [
            'event' => $event,
            'avisPassageText' => $avisPassageText,
            'localite' => $localite->Localite,
            'btnReturn' => false,
        ];

        $pdf = Pdf::loadView('documents.templateDocument.viewAvisPassage', $data);

        return $pdf->download($document->link);
    }


    public function downloadExcelFormCreateApps($id)
    {
        $client = Client::where('id', $id)->first();
        $localite = CodePostelb::where('codePost', $client->codepost)->first();

        $data = [
            'client' => $client,
            'localite' => $localite->Localite,
        ];

        return Excel::download(new ClientExport($client, $localite->Localite), $client->nom.'-Formulaire_Appartements.xlsx');
    }

    public function showImportForm()
    {
        return view('immeubles.show');
    }

    public function import(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Store the uploaded file temporarily
        $path = $request->file('file')->store('temp');
        $data = Excel::toCollection(new ClientsImport, storage_path('app/' . $path));

        // Array to keep track of apartments and their details
        $apartmentDetails = [];
        $client = Client::where('nom', $data[0][0]['nom_batiment'])->first();
        $codecli = $client->Codecli;


        foreach ($data[0] as $row) {

                    $apartmentDetails[] = [
                        'client' => $codecli,
                        'ref_app_tr' => count($apartmentDetails) + 1,
                        'nbr_calorimetre' => $row['nbr_calorimetre'],
                        'nbr_compt_eau_c' => $row['nbr_compt_eau_c'],
                        'nbr_compt_eau_f' => $row['nbr_compt_eau_f'],
                        'nom_locataire' => $row['nom_locataire'],
                        'nbr_integrateur' => $row['nbr_integrateur'],
                        'commentaire' => $row['commentaire']
                    ];

        }

        $result = [
            'codecli' => $codecli,
            'nbr_app' => 0,
            'nbr_compt_eau_f' => 0,
            'nbr_compt_eau_c' => 0,
            'nbr_calorimetre' => 0,

        ];
        foreach ($apartmentDetails as $key => $details) {

            $relChaufApp = new RelChaufApp();
            $relChaufApp->Codecli = $details['client'];
            $relChaufApp->RefAppTR = $details['ref_app_tr'];
            $relChaufApp->NbRad = $details['nbr_calorimetre'];
            $relChaufApp->save();

            $relEauApp = new RelEauApp();
            $relEauApp->Codecli = $details['client'];
            $relEauApp->RefAppTR = $details['ref_app_tr'];
            $relEauApp->NbCptFroid = $details['nbr_compt_eau_f'];
            $relEauApp->NbCptChaud = $details['nbr_compt_eau_c'];
            $relEauApp->save();

            $result ['nbr_app']= $key +1 ;
            $result ['nbr_compt_eau_f'] += $details['nbr_compt_eau_f'];
            $result ['nbr_compt_eau_c'] += $details['nbr_compt_eau_c'];
            $result ['nbr_calorimetre'] += $details['nbr_calorimetre'];


        }

        //dd($result);
        return redirect()->back()
            ->with('success', 'Clients imported successfully.')
            ->with('result', $result);
    }

    public function showChauffage()
    {

        return view('documents.templateDocument.vueChauffage');

    }


    public function test()
    {
        return view('test');
    }





}

