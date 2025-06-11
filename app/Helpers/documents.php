<?php

use App\Models\AvisPassageText;
use App\Models\Client;
use App\Models\CodePostelb;
use App\Models\Document;
use App\Models\Event;
use Carbon\Carbon;
use http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
    if(!function_exists('downloadPDF')) {

        function downloadPDF($id, $type, $date)
        {

            $event = Event::where('client_id', $id)
                ->where('start', 'like', $date . '%')
                ->with('client.cliEaus')
                ->with('client.clichaufs')
                ->with('client.codePostelbs')
                ->with('client.gerantImms.contacts')
                ->with('typeEvent')
                ->orderBy('start', 'desc')
                ->first();



            if (!$event) {
                abort(404, 'Event not found');
            }

            $client = $event->client;

            if (!$client) {
                abort(404, 'Client not found');
            }

            if ($type == 'Bon') {
                $type = 'BonDeRoute';
                $docTyp = 'Bon de route';
                $view = 'documents.templateDocument.viewBonRoute';
                $avisPassageText = '';
            } else if ($type == 'Avis') {
                $type = 'AvisDePassage';
                $docTyp = 'Avis de passage';
                $view = 'documents.templateDocument.viewAvisPassage';
                // choisir avis passage texts selon le type d'appareil et le type d'event
               $avisPassageText = AvisPassageText::where('type_event_id', $event->type_event_id);

                if ($client->clichaufs->count() > 0 && $client->cliEaus->count() > 0) {

                    if ($client->clichaufs->first()->TypeRlv == $client->cliEaus->first()->TypeRlv) {
                        $avisPassageText = $avisPassageText->where('TypRlv', $client->clichaufs[0]->TypRlv);

                    } else {
                        $avisPassageText = $avisPassageText->where('TypRlv', 'mixte');
                    }
                } elseif ($client->clichaufs->count() > 0) {
                    $avisPassageText = $avisPassageText->where('TypRlv', $client->clichaufs[0]->TypRlv);
                } elseif ($client->cliEaus->count() > 0) {
                    $avisPassageText = $avisPassageText->where('TypRlv', $client->cliEaus[0]->TypRlv);
                } else {
                    $avisPassageText = $avisPassageText->where('TypRlv', 'autre');
                }

                $avisPassageText = $avisPassageText->first();

            }else if ($type == 'FicheRep') {

                $type = 'FicheRepartition';
                $docTyp = 'Fiche de répartition';
                if($client->gerantImms[0]->contacts->count() > 0){
                    if($client->gerantImms[0]->contacts[0]->codLng == 'FR'){
                        $view = 'documents.templateDocument.viewFeuilleFraisFR';
                    }else{
                        $view = 'documents.templateDocument.viewFeuilleFraisND';
                    }
                }else{
                    $view = 'documents.templateDocument.viewFeuilleFraisFR';
                }
                $avisPassageText = '';
            }
            else {
                abort(404, 'Document type not found');
            }

            $localite = CodePostelb::where('codePost', $client->codepost ?? $client->codepostger)->first()->Localite;
            $localiteGer = CodePostelb::where('codePost', $client->codepostger)->first()->Localite;

            $data = [
                'event' => $event,
                'localite' => $localite,
                'localiteGer' => $localiteGer,
                'btnReturn' => false,
                'avisPassageText' => $avisPassageText,
            ];

            $formattedDate = Carbon::parse($event->start)->format('Y');

            // Générer le document PDF
            $filename = 'storage/documents/' . $event->id.'_'.$event->client->nom . '-' . $formattedDate . '-' . $type . '.pdf';

            $pdf = Pdf::loadView($view, $data);
            $content = $pdf->output();

            $document = Document::where('link', $filename)->first();



            if (empty($document)) {

                // Enregistrer le document dans la base de données
                $document = new Document();
                $document->type = $docTyp;
                $document->link = $filename;
                $document->event_id = $event->id;
                $document->client_id = $id;
                $document->save();


            }else{

                $document->update([
                    'type' => $docTyp,
                    'link' => $filename,
                    'event_id' => $event->id,
                    'client_id' => $id,
                ]);

            }

            Storage::put($filename, $content);
            $pdf->download($filename);

            return ('ok');
        }
    }

    if(!function_exists('downloadPDFListeSDC')) {

        function downloadPDFListeSDC($month)
        {

            $view = 'documents.listeSDC.listeSdcPdf';
            $year = Carbon::now()->year;
            $filename = 'storage/documents/ListeSDC_'.$month.'_'.$year.'.pdf';
            $docTyp = 'Liste SDC';

            $clients = Client::whereRaw('RIGHT(dernierreleve, 2) = ?', [$month])->with('codePostelbs', 'events')->orderBy('nom')->get();

            // générer un fichier pdf en utilisant la vue documents.listeSDC.listeSdcPd
            $pdf = PDF::loadView($view, compact('clients', 'month'));
            $content = $pdf->output();

            $createDate = carbon::create($year . '-'.$month . '-01 00:00:00')->format('Y-m-d H:i:s');

            // Enregistrer le document dans la base de données
            $document = new Document();
            $document->type = $docTyp;
            $document->link = $filename;
            $document->event_id = null;
            $document->send_at = $createDate;
            $document->client_id = null;
            $document->save();

            Storage::put($filename, $content);

            return ('ok');

        }
    }
