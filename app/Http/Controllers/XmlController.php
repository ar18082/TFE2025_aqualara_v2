<?php

namespace App\Http\Controllers;


use App\Models\Appartement;
use App\Models\Clichauf;
use App\Models\CliEau;
use App\Models\CommentXml;
use App\Models\Event;
use App\Models\FileXml;
use App\Models\ReleveRadio;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use App\Models\Client;
use Carbon\Cli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Tests\Laravel\App;
use function Sodium\add;
use Illuminate\Support\Carbon;
class XmlController extends Controller
{


    public function testJson(Request $request){

        return response()->json(['message' => 'c\'est ok']);
    }


    public function testerParser(Request $request)
    {

        if ($request->isMethod('post') || !empty($request->all())) {
            $datas = $request->all();
            CommentXml::create($datas);
        }


        return view('XML.parser', ['title' => 'parserXmlFile']);
    }


    private function processTasks($array)
    {

        $datasXML = [];

        foreach ($array as $task) {

            if (is_array($task) && array_key_exists('Param', $task)) {

                $numcal = $task['Param']['RadioAddr'];
                $datasXML[$numcal] = [
                    'lastActionDate' => $task['LastActionDate'],
                    'agent' => $task['@attributes']['Agent'],
                    'caption' => $task['@attributes']['Caption'],
                    'status' => $task['@attributes']['Status'],
                ];


            }

            if (isset($task['Data']['MbusRecord']) || !empty($task['Data']['MbusRecord'])) {

                foreach ($task['Data']['MbusRecord'] as $record) {

                    $accessKey = $record['Key']['@attributes']['AccessKey'];
                    $name = $record['Key']['@attributes']['Name'];
                    $subunit = $record['Key']['@attributes']['Subunit'];
                    $tariff = $record['Key']['@attributes']['Tariff'];
                    $storage = $record['Key']['@attributes']['Storage'];
                    $function = $record['Key']['@attributes']['Function'];
                    $value = $record['Value'];

                    if (!empty($storage) || $storage == 0) {

                        $storageKey = strval($storage);


                        if (!isset($records[$storageKey])) {
                            $records[$storageKey] = [];
                        }

                        if ($name == 'FlowTemperature') {
                            if ($function == 1 && $storageKey == '1') {
                                $records[$storageKey][$name . '_TmaxRad'] = [
                                    'accassKey' => $accessKey,
                                    'name' => $name,
                                    'subunit' => $subunit,
                                    'tariff' => $tariff,
                                    'storage' => $storage,
                                    'function' => $function,
                                    'value' => $value,
                                ];
                            } elseif ($function == 1 && $storageKey == '0') {
                                $records[$storageKey][$name . '_TmRel'] = [
                                    'accassKey' => $accessKey,
                                    'name' => $name,
                                    'subunit' => $subunit,
                                    'tariff' => $tariff,
                                    'storage' => $storage,
                                    'function' => $function,
                                    'value' => $value,
                                ];
                            } elseif ($function == 0 && $storageKey == '0') {
                                $records[$storageKey][$name . '_Trad'] = [
                                    'accassKey' => $accessKey,
                                    'name' => $name,
                                    'subunit' => $subunit,
                                    'tariff' => $tariff,
                                    'storage' => $storage,
                                    'function' => $function,
                                    'value' => $value,
                                ];
                            }
                        }

                        if ($name == 'CumulationCounter') {
                            $records[$storageKey][$name][$tariff] = [
                                'accassKey' => $accessKey,
                                'name' => $name,
                                'subunit' => $subunit,
                                'tariff' => $tariff,
                                'storage' => $storage,
                                'function' => $function,
                                'value' => $value,
                            ];
                        } else {
                            $records[$storageKey][$name] = [
                                'accassKey' => $accessKey,
                                'name' => $name,
                                'subunit' => $subunit,
                                'tariff' => $tariff,
                                'storage' => $storage,
                                'function' => $function,
                                'value' => $value,
                            ];
                        }

                        $datasXML[$numcal] = $records;
                    }
                }
            }


        }


        return $datasXML;

    }
    private function processGroup($array) {
        $dataXml = [];

        if (array_key_exists('Group', $array)) {
            $group = $array['Group'];

            if (is_array($group)) {
                foreach ($group as $value) {
                    if (array_key_exists('Task', $value)) {
                        if (array_key_exists('@attributes', $value)) {
                            $lieu = $value['@attributes']['Caption'];
                            $dataXml[$lieu] = $this->processTasks($value['Task']);
                        }
                    } elseif (array_key_exists('Group', $value)) {
                        // Appel récursif de la fonction pour traiter les sous-groupes
                        $dataXml = array_merge($dataXml, $this->processGroup($value));
                    }
                }
            } else {
                dd(" array['Group'] n'est pas un array dans la fonction processGroup");
            }
        } else {
            dd("array['Group'] n'existe pas dans la fonction processGroup");
        }

        return $dataXml;
    }



    public function parserXmlFile(Request $request)
    {

        if ($request->hasFile('file')) {
            // Récupérer le fichier téléchargé
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();


            if ($file->getClientOriginalExtension() === 'xml') {

                $datas = file_get_contents($file->path());
                $xml = simplexml_load_string($datas);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);

                //$saveDate = $array['SaveDate'];
                //$codeCli = 16;
                $datasXML=[];



                if(is_array($array) && array_key_exists('Task', $array)){
                        $tasks = $this->processTasks($array);
                }elseif(array_key_exists('Group', $array)){
                    if(array_key_exists('@attributes', $array)){

                        $tasks = $this->processGroup($array);

                    }

                }
                $datasXML = $tasks;



                return view('XML.test',
                    [
                        'title' => 'Parser ',
                        'datasXML' => $datasXML,
                        'fileName' => $fileName,
                    ]);

            } else {
                return response()->json(['success' => false, 'message' => 'Le fichier téléchargé n\'est pas un fichier XML']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Aucun fichier n\'a été téléchargé']);
        }
    }


//    private function generateXmlFile()
//    {
//        $currentDate = Carbon::now();
//        $events = Event::where('valide', true)
//            //-> where('start', '>', $currentDate)
//            ->get();
//
//        foreach ($events as $event) {
//           //$codeCli = $event->client->Codecli;
//            $codeCli = 2097;
//            $client = Client::where('codeCli', $codeCli)->first();
//            $clichauf = Clichauf::where('Codecli', $codeCli)->first();
//            $appartements = Appartement::where('Codecli', $codeCli)->get();
//
//
//            $clichaufs = Clichauf::where('client_id', $client->id)
//                ->where('CodeCli', $codeCli)
//                ->first();
//            $cliEaus = CliEau::where('client_id', $client->id)
//                ->where('CodeCli', $codeCli)
//                ->first();
//
//
//            // si le type de relevé de clichaufs ou clieau est radio alors on exécute pour récupéer les n°serie appareil
//            if ($clichaufs && $cliEaus && ($clichaufs->TypRlv == 'RADIO' || $cliEaus->TypRlv == 'RADIO')) {
//                $relRads = $this->getRelRads($codeCli, $appartements, $clichaufs, $cliEaus);
//
//                $this->generateXmlDocuments($relRads, $codeCli);
//            }
//        }
//
//        $xmlFiles = FileXml::all();
//        //dd($xmlFiles[0]->FileName);
//
//        return view('XML.Generate', [
//            'title' => 'generateXmlFile',
//            'xmlFiles' => $xmlFiles,
//        ]);
//    }

    public function generateXml($event)
    {
        $currentDate = Carbon::now();
        $client = Client::where('id', $event->client_id)
            ->with('appartements')
            ->with('clichaufs')
            ->with('cliEaus')
            ->with('appareils')
            ->first();

        $relRads = $this->getRelRads($client);
        $this->generateXmlDocuments($relRads, $client);

    }

    // private Helpers  getRelRads et getRelRadsByType pour récup n°serie
    private function getRelRads($client)
    {
        $relRads = collect([]);

        if ($client->clichaufs->first()->TypRlv == 'RADIO') {
            //vérification si il existe déja des relevés radio pour le client

            $relRads = $relRads->merge($this->getRelRadsByType('rel_rad_chfs', $client->Codecli, $client->appartements));


            if($relRads->isEmpty()){
               // créer un xml
              $test = $client->appareils->where('TypeReleve', 'RADIO_CH')->first();


            }



        }
        if ($client->cliEaus->first()->TypRlv == 'RADIO') {
            //vérification si il existe déja des relevés radio pour le client
            $relRads = $relRads->merge($this->getRelRadsByType('rel_rad_eaus', $client->Codecli, $client->appartements));
        }

        return $relRads;
    }

    private function getRelRadsByType($table, $codeCli, $appartements)
    {

        return DB::table($table)
            ->select('Numcal', 'RefAppTR')
            ->whereIn('RefAppTR', $appartements->pluck('RefAppTR'))
            ->where('Codecli', $codeCli)
            ->distinct()
            ->get();
    }

    private function generateXmlDocuments($relRads, $client)
    {

        $xmlFilePath = storage_path('xml_files/00' . $client->Codecli . '-' . $client->nom . '.xml');

        $fileXml = new FileXml();
        $fileXml->link  = $xmlFilePath;
        $fileXml->fileName = 'xml_files/00' . $client->Codecli . '-' . $client->nom . '.xml';
        $fileXml->save();

        $xmlDoc = new \DOMDocument('1.0', 'UTF-8');
        $roadElement = $xmlDoc->createElement('Road');
        $roadElement->setAttribute('Version', '6.2');
        $xmlDoc->appendChild($roadElement);

        $savedByElement = $xmlDoc->createElement('SavedBy');
        $savedByElement->setAttribute('SwName', 'Tools Supercom');
        $savedByElement->setAttribute('SwVersion', '2.5.1');
        $roadElement->appendChild($savedByElement);

        $saveDateElement = $xmlDoc->createElement('SaveDate', '2020-11-06T10:16:55.799+01:00');
        $roadElement->appendChild($saveDateElement);

        foreach ($client->appartements as $key => $appartement) {
            $groupElement = $xmlDoc->createElement('Group');
            $groupElement->setAttribute('Caption', $appartement->RefAppCli);
            $roadElement->appendChild($groupElement);
            $groupAppElement = $xmlDoc->createElement('Group');
            $groupAppElement->setAttribute('Caption', $appartement->RefAppTR);
            $groupElement->appendChild($groupAppElement);
            foreach ($relRads as $relRad) {

                if($relRad->RefAppTR == $key){
                    $taskElement = $xmlDoc->createElement('Task');
                    $taskElement->setAttribute('Agent', 'http://www.sontex.com/WirelessMBus-read');
                    $taskElement->setAttribute('Caption', 'Lecture wM-Bus');
                    $taskElement->setAttribute('Status', 'ToDo');
                    $groupAppElement->appendChild($taskElement);

                    $paramElement = $xmlDoc->createElement('Param');
                    $taskElement->appendChild($paramElement);
                    $radioAddrElement = $xmlDoc->createElement('RadioAddr', $relRad->Numcal);
                    $radioAddrElement->setAttribute('ManufacturerId', 'SON');
                    $paramElement->appendChild($radioAddrElement);
                }

                $xmlDoc->save($xmlFilePath);
            }
        }
    }




}
