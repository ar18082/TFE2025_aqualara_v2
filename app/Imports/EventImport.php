<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Event;
use App\Models\EventTechnicien;
use App\Models\Technicien;
use App\Models\TypeEvent;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class EventImport implements ToModel, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected function convertisseurAgendaSearchClient(array $data)
    {
        $nom = explode(' ', $data[2]);
        $adress = '';
        if(isset($data[13]) && $data[13] != ''){
            $adress = substr($data[13], strpos($data[13], ' ') + 1);
        }
        $client = null;
        // $data est un tableau contenant + de 1 élément
        if(count($nom) > 1){
            $client = Client::where('nom', 'like', "%{$nom[0]} {$nom[1]}%")->first();

            if ($client == null) {
                $client = Client::where('nom', 'like', "%{$nom[0]}%")->first();

                if ($client == null) {
                    $client = Client::where('rue', 'like', "%{$adress}%")->first();

                }
            }
        }

        return $client;
    }

    public function model(array $row)
    {


        //row important
        //row[2] = titre (il faut explode pour avoir nom du client et typeEvent)
        //row[3] = date debut
        //row[4] = date fin
        //row[5] = Heure debut
        //row[6] = Heure fin
        //row[12] = description
        //row[13] = adresse
        //row[19] = couleur
        $datasRejet = [];

        $rejected = true;
        if (isset($row[2]) && strlen($row[2]) > 0) {
            $data = explode(' - ', $row[2]);
            if (isset($data[0])) {
                $client = $this->convertisseurAgendaSearchClient($row);
                if ($client != null) {
                    if (isset($data[1])) {
                        $abreviation = explode(' ', $data[1]);
                        $typeEvent = TypeEvent::where('abreviation', 'like', "%{$abreviation[0]}%")->first();
                        if ($typeEvent != null) {
                            $rejected = false;
                            $start = $row[3] . ' ' . $row[5] . ':00';
                            $end = $row[4] . ' ' . $row[6] . ':00';
                            $event = Event::where('client_id', $client->id)
                                ->where('type_event_id', $typeEvent->id)
                                ->where('start', Carbon::parse($start)->format('Y-m-d H:i:s'))
                                ->where('end', Carbon::parse($end)->format('Y-m-d H:i:s'))
                                ->first();
                            if ($event == null) {
                                $newEvent = new Event();
                                $newEvent->client_id = $client->id;
                                $newEvent->type_event_id = $typeEvent->id;
                                $newEvent->start = Carbon::parse($start)->format('Y-m-d H:i:s');
                                $newEvent->end = Carbon::parse($end)->format('Y-m-d H:i:s');
                                $newEvent->commentaire = $row[12];
                                $newEvent->save();

                                $couleur = isset($row[19]) && $row[19] != '' ? $row[19] : 'orange';

                                switch ($couleur) {
                                        case 'Raisin' :
                                            $couleur = 'mauve';
                                            break;
                                        case 'Banane' :
                                            $couleur = 'jaune';
                                            break;
                                        case 'Basilic' :
                                            $couleur = 'vert';
                                            break;
                                        case 'Myrtille' :
                                            $couleur = 'Bleu Marine';
                                            break;
                                        case 'Anthracite' :
                                            $couleur = 'gris';
                                            break;
                                        case 'Tomate' :
                                            $couleur = 'rouge';
                                            break;
                                        case 'Sauge' :
                                            $couleur = 'bleu';
                                            break;
                                        case 'lavande' :
                                            $couleur = 'vert Fonce';
                                            break;
                                        case 'Rose clair' :
                                            $couleur = 'rose';
                                            break;

                                        default:
                                            $couleur = 'orange';

                                    }
                                $technicien = Technicien::whereHas('colorTechnicien', function($query) use ($couleur) {
                                    $query->where('couleur', $couleur);
                                })->first();

                                if ($technicien != null) {
                                    $eventTechnicien = new EventTechnicien();
                                    $eventTechnicien->event_id = $newEvent->id;
                                    $eventTechnicien->technicien_id = $technicien->id;
                                    $eventTechnicien->save();
                                }
                            }
                        }

                    }
                }

            }
        }
        if ($rejected) {
            array_push($datasRejet, $row);
        }

//        return new Event([
//            //
//        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
