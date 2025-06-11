<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Models\EventTechnicien;
use App\Models\Technicien;
use App\Models\TypeEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvertisseurGoogleAgendaController extends Controller
{
    protected function convertisseurAgendaSearchClient(array $data)
    {
        ini_set('max_execution_time', 5000);
        $search = '';
        $resultClient = [];
        $foundClient = [];

        $nom = explode(' ', $data[2]);
        if (isset($data[13]) && $data[13] != '') {
            $adress = explode(' ', $data[13]);
        }

        foreach ($nom as $n) {
            $search .= $n . ' ';

            $client = Client::where('nom', 'like', "%{$search}%")
                ->with('appartements', 'cliEaus', 'clichaufs', 'appareils', 'codePostelbs')
                ->get();
            if($client->count() >= 1){
                break;
            }

        }

        if($client->count() >= 1){
            foreach ($client as $c) {
                if(in_array($c->codepost, $nom)){
                    array_push($foundClient, $c);

                }elseif (isset($adress) && in_array($c->codepost, $adress)) {
                    array_push($foundClient, $c);
                }
            }
        }

        if(count($foundClient) >= 1){

            $bestMatchClient = null;
            $maxMatches = 0;

            foreach ($foundClient as $f) {
                $rue = explode(' ', $f->rue);
                $matches = count(array_intersect($rue, $adress));

                if ($matches > $maxMatches) {
                    $maxMatches = $matches;
                    $bestMatchClient = $f;
                }

            }

            if ($bestMatchClient) {
                array_push($resultClient, $bestMatchClient);
            } else {
                return null;
            }

        }

        if(count($resultClient) == 1){
            return $resultClient[0];
        }else{
            return null;
        }

    }

    protected function convertisseurAgendaSearchTypEvent(array $data)
    {
        $typeEvent = null;
        foreach ($data as $d) {
            $typeEvent = TypeEvent::where('abreviation', 'like', "%{$d}%")->first();
            if($typeEvent != null){
                break;
            }
        }

        return $typeEvent;

    }

    protected function convetisseurAgendaTraitementDates($date, $heures)
    {
        $dateformated = null;
        // traitement de la date
        $dateExplode = explode('-', $date);
        if(count($dateExplode) == 3){
            $yearLenght = strlen($dateExplode[2]);
        }else{
            return  null;
        }


        switch ($yearLenght) {
            case 2:
                $year = '20' . $dateExplode[2];
                break;
            case 4:
                $year = $dateExplode[2];
                break;
            default:
                $year = explode(' ', $dateExplode[2]);
                if(count($year) > 1){
                    unset ($year[1]);
                    $length = strlen($year[0]);
                    if($length < 4){
                        $year[0] = '20'.$year[0];
                    }else{
                        $year = $year[0];
                    }
                }
        }

        $date = $year . '-' . $dateExplode[1] . '-' . $dateExplode[0];

        //traitement des heures
        $heuresExplode = explode(':', $heures);

        if(count($heuresExplode) == 2){
            $heures = $heuresExplode[0] . ':' . $heuresExplode[1] . ':00';
        }

        $dateComplete = $date . ' ' . $heures;

        $dateformated = Carbon::createFromFormat('Y-m-d H:i:s', $dateComplete)->toDateTimeString();



        return $dateformated;
    }

    protected function convetisseurAgendaTraitementTechnicien($couleur)
    {

        // reecrire cette function voir doc
        $technicien = null;

        switch ($couleur) {
            case 'Raisin' :
                $couleur = 'mauve';
                break;
            case 'Sauge' :
                $couleur = 'mauve';
                break;
            case 'Banane' :
                $couleur = 'jaune';
                break;
            case 'Basilic' :
                $couleur = 'vert Fonce';
                break;
            case 'Mandarine' :
                $couleur = 'vert Fonce';
                break;
            case 'Anthracite' :
                $couleur = 'gris';
                break;
            case 'lavande' :
                $couleur = 'bleu marine';
                break;
            case 'Rose clair' :
                $couleur = 'gris';
                break;
            case 'Blue paon' :
                $couleur = 'bleu';
                break;
            default:
                $couleur = '';


        }

        if($couleur != ''){

            $technicien = Technicien::with('colorTechnicien')
                ->whereHas('colorTechnicien', function ($query) use ($couleur) {
                    $query->where('couleur', $couleur);
                })
                ->first();

        }

        return $technicien;
    }

    public function convertisseurAgenda()
    {

        $fileName = 'Agenda2024.csv';
        // Récupérer le fichier CSV
        $file = Storage::disk('public')->get('agendaCSV/' . $fileName);

        //dd($file);
        // Traiter le fichier
        $lines = explode("\r", $file);
        // Créer un tableau pour les données rejetées pour générer un CSV
        $datasRejet = [];
        $dataValide = [];

        // Supprimer la première ligne
        array_shift($lines);

        $nbTotLines = count($lines);
        $nbRejet = 0;
        $nbValide = 0;
        $nbExistant = 0;



        foreach ($lines as $line) {

            $datas = str_getcsv($line);
            $datas = explode(';', $datas[0]);

            if (isset($datas[2]) && strlen($datas[2]) > 0) {
                $data = explode(' ', $datas[2]);

                try {

                    if(isset($datas[19])){
                        $couleur = $datas[19];

                    }else{
                        $couleur = '';
                    }
                    // recherche du technicien
                    $technicien = $this->convetisseurAgendaTraitementTechnicien($couleur);

                    $client = $this->convertisseurAgendaSearchClient($datas);


                    $typeEvent = $this->convertisseurAgendaSearchTypEvent($data);

                    $start = $this->convetisseurAgendaTraitementDates($datas[3], $datas[5]);

                    $end = $this->convetisseurAgendaTraitementDates($datas[4], $datas[6]);

                    $commentaire = mb_convert_encoding($datas[12], 'UTF-8', 'ISO-8859-1');



                    if($client != null && $typeEvent != null &&  $start != null && $end != null && $technicien != null){


                        $event = Event::where('client_id', $client->id)
                            ->where('type_event_id', $typeEvent->id)
                            ->where('start', $start)
                            ->where('end', $end)
                            ->first();

                        if($event == null){
                            $event = new Event();
                            $event->client_id = $client->id;
                            $event->type_event_id = $typeEvent->id;
                            $event->start = $start;
                            $event->end = $end;
                            $event->commentaire = $commentaire;
                            $event->save();

                            $eventTechnicien = new EventTechnicien();
                            $eventTechnicien->event_id = $event->id;
                            $eventTechnicien->technicien_id = $technicien->id;
                            $eventTechnicien->save();

                            $rejected = 0;

                        }else{
                            $rejected = 2;
                        }
                    }else{
                        $rejected = 1;
                    }

                }
                catch (\Exception $e) {
                    $rejected = 1;
                }


            }else{
                $rejected = 1;
            }


            switch ($rejected) {
                case 0:
                    $nbValide++;
                    array_push($dataValide, $datas);
                    break;
                case 1:
                    $nbRejet++;
                    array_push($datasRejet, $datas);
                    break;
                case 2:
                    $nbExistant++;
                    break;
            }

        }

        // dd($dataValide);

        // Générer un CSV pour les données rejetées
        $rejectedCsv = '';
        foreach ($datasRejet as $rejectedData) {
            $rejectedCsv .= implode(';', $rejectedData) . "\n";
        }
        Storage::disk('public')->put('rejectedCSV/rejected_data_' .$fileName , $rejectedCsv);


        return redirect()->route('admin.event.index')->with('success', $fileName. ' contenait : '.$nbTotLines. ' d\'éléments; ' . $nbValide . ' événements ont été créés et ' . $nbRejet . ' événements ont été rejetés et ' . $nbExistant . ' événements existants.');
    }
}
