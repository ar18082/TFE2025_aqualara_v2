<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use App\Models\Clichauf;
use App\Models\CliEau;
use App\Models\Client;
use App\Models\CodePostelb;
use App\Models\Contact;
use App\Models\GerantImm;
use App\Models\relApp;
use App\Models\RelChauf;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use PDO;

class SyncController extends Controller
{
    protected PDO $conn;

    public function __construct()
    {
        $this->conn = new PDO('sqlsrv:server=127.0.0.1;Database=SDCCLI', 'sa', 'Azerty123456');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function index()
    {
        return view('admin.sync.index');
    }

    public function popContact()
    {
        $queryContact = 'SELECT TOP 100000 *  FROM  "User-Pro-Ger"';
        $prep = $this->conn->prepare($queryContact);
        $prep->execute();
        $contacts_mssql = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate contact

        $contacts_to_insert = [];
        $contacts_to_update = [];
        $contacts_already_updated = [];

        //        $AllContacts = Contact::all();

        foreach ($contacts_mssql as $contact_mssql) {
            // check if contact exist in $AllContacts (eloquent collection) search by codunique
            //            $contact = $AllContacts->where('codunique', $contact_mssql['CodUnique'])->first();
            //            $contact = $AllContacts->firstWhere('codunique', $contact_mssql['CodUnique']);
            //            $contact = $AllContacts->filter(function ($value, $key) use ($contact_mssql) {
            //                return $value->codunique == $contact_mssql['CodUnique'];
            //            })->first();

            $contact = \App\Models\Contact::where('codunique', $contact_mssql['CodUnique'])->first();
            if (! $contact) {
                $contact = new \App\Models\Contact();
                $contact->p_g = $contact_mssql['P-G'];
                $contact->codunique = $contact_mssql['CodUnique'];
                if ($contact_mssql['P-G'] == 'P') {
                    $contact->codproprio = $contact_mssql['CodUnique'];
                }
                if ($contact_mssql['P-G'] == 'G') {
                    $contact->codgerant = $contact_mssql['CodUnique'];
                }
                $contact->coduser = $contact_mssql['CodUser'];
                $contact->inscrit = $contact_mssql['Inscrit'];
                $contact->desinsadm = $contact_mssql['DesInsAdm'];
                $contact->date_fin = $contact_mssql['Date-fin'];
                $contact->titre = $contact_mssql['Titre'];
                $contact->nom = $contact_mssql['Nom'];
                $contact->rue = $contact_mssql['Rue'];
                $contact->boite = $contact_mssql['Boite'];
                $contact->pays = $contact_mssql['Pays'];
                $contact->codpost = $contact_mssql['CodPost'];
                $contact->tel = $contact_mssql['Tel'];
                $contact->gsm = $contact_mssql['Gsm'];
                $contact->fax = $contact_mssql['Fax'];
                $contact->email1 = $contact_mssql['Email1'];
                $contact->email2 = $contact_mssql['Email2'];
                $contact->email3 = $contact_mssql['Email3'];
                $contact->email4 = $contact_mssql['Email4'];
                $contact->email5 = $contact_mssql['Email5'];
                $contact->comment = $contact_mssql['Comment'];
                $contact->codlng = $contact_mssql['CodLng'];
                $contact->codfichier = $contact_mssql['CodFichier'];
                $contact->pwd = $contact_mssql['PWD'];
                $contact->token = $contact_mssql['Token'];
                $contact->token_date = $contact_mssql['Token-Date'];
                $contact->oldproprio = $contact_mssql['Oldproprio'];

                $contacts_to_insert[] = $contact;

            } else {
                $contactModified = false;
                // update existing contact
                if ($contact->p_g != $contact_mssql['P-G']) {
                    $contact->p_g = $contact_mssql['P-G'];
                    $contactModified = true;
                }

                if ($contact_mssql == 'P') {
                    if ($contact->codproprio != $contact_mssql['CodUnique']) {
                        $contact->codproprio = $contact_mssql['CodUnique'];
                        $contactModified = true;
                    }
                }

                if ($contact_mssql == 'G') {
                    if ($contact->codgerant != $contact_mssql['CodUnique']) {
                        $contact->codgerant = $contact_mssql['CodUnique'];
                        $contactModified = true;
                    }
                }

                if ($contact->coduser != $contact_mssql['CodUser']) {
                    $contact->coduser = $contact_mssql['CodUser'];
                    $contactModified = true;
                }

                if ($contact->inscrit != $contact_mssql['Inscrit']) {
                    $contact->inscrit = $contact_mssql['Inscrit'];
                    $contactModified = true;
                }

                if ($contact->desinsadm != $contact_mssql['DesInsAdm']) {
                    $contact->desinsadm = $contact_mssql['DesInsAdm'];
                    $contactModified = true;
                }

                if ($contact->date_fin != $contact_mssql['Date-fin']) {
                    $contact->date_fin = $contact_mssql['Date-fin'];
                    $contactModified = true;
                }

                if ($contact->titre != $contact_mssql['Titre']) {
                    $contact->titre = $contact_mssql['Titre'];
                    $contactModified = true;
                }

                if ($contact->nom != $contact_mssql['Nom']) {
                    $contact->nom = $contact_mssql['Nom'];
                    $contactModified = true;
                }

                if ($contact->rue != $contact_mssql['Rue']) {
                    $contact->rue = $contact_mssql['Rue'];
                    $contactModified = true;
                }

                if ($contact->boite != $contact_mssql['Boite']) {
                    $contact->boite = $contact_mssql['Boite'];
                    $contactModified = true;
                }

                if ($contact->pays != $contact_mssql['Pays']) {
                    $contact->pays = $contact_mssql['Pays'];
                    $contactModified = true;
                }

                if ($contact->codpost != $contact_mssql['CodPost']) {
                    $contact->codpost = $contact_mssql['CodPost'];
                    $contactModified = true;
                }

                if ($contact->tel != $contact_mssql['Tel']) {
                    $contact->tel = $contact_mssql['Tel'];
                    $contactModified = true;
                }

                if ($contact->gsm != $contact_mssql['Gsm']) {
                    $contact->gsm = $contact_mssql['Gsm'];
                    $contactModified = true;
                }

                if ($contact->fax != $contact_mssql['Fax']) {
                    $contact->fax = $contact_mssql['Fax'];
                    $contactModified = true;
                }

                if ($contact->email1 != $contact_mssql['Email1']) {
                    $contact->email1 = $contact_mssql['Email1'];
                    $contactModified = true;
                }

                if ($contact->email2 != $contact_mssql['Email2']) {
                    $contact->email2 = $contact_mssql['Email2'];
                    $contactModified = true;
                }

                if ($contact->email3 != $contact_mssql['Email3']) {
                    $contact->email3 = $contact_mssql['Email3'];
                    $contactModified = true;
                }

                if ($contact->email4 != $contact_mssql['Email4']) {
                    $contact->email4 = $contact_mssql['Email4'];
                    $contactModified = true;
                }

                if ($contact->email5 != $contact_mssql['Email5']) {
                    $contact->email5 = $contact_mssql['Email5'];
                    $contactModified = true;
                }

                if ($contact->comment != $contact_mssql['Comment']) {
                    $contact->comment = $contact_mssql['Comment'];
                    $contactModified = true;
                }

                if ($contact->codlng != $contact_mssql['CodLng']) {
                    $contact->codlng = $contact_mssql['CodLng'];
                    $contactModified = true;
                }

                if ($contact->codfichier != $contact_mssql['CodFichier']) {
                    $contact->codfichier = $contact_mssql['CodFichier'];
                    $contactModified = true;
                }

                if ($contact->pwd != $contact_mssql['PWD']) {
                    $contact->pwd = $contact_mssql['PWD'];
                    $contactModified = true;
                }

                if ($contact->token != $contact_mssql['Token']) {
                    $contact->token = $contact_mssql['Token'];
                    $contactModified = true;
                }

                if ($contact->token_date != $contact_mssql['Token-Date']) {
                    $contact->token_date = $contact_mssql['Token-Date'];
                    $contactModified = true;
                }

                if ($contact->oldproprio != $contact_mssql['Oldproprio']) {
                    $contact->oldproprio = $contact_mssql['Oldproprio'];
                    $contactModified = true;
                }

                if ($contactModified) {
                    $contacts_to_update[] = $contact;
                } else {
                    $contacts_already_updated[] = $contact;
                }

            }
        }

        // insert contacts
        foreach ($contacts_to_insert as $contact_to_insert) {
            $contact_to_insert->save();
        }

        // update contacts
        foreach ($contacts_to_update as $contact_to_update) {
            $contact_to_update->save();
        }

        //        var_dump('ok',
        //            'contacts_to_insert:'. count($contacts_to_insert),
        //            'contacts_to_update:'.count($contacts_to_update),
        //            'contacts_already_updated:'.count($contacts_already_updated),
        //        );
        //        dd('ok');

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Contact',
                'itemInsert' => count($contacts_to_insert),
                'itemUpdate' => count($contacts_to_update),
                'itemUnchanged' => count($contacts_already_updated),
                'itemTotal' => count($contacts_to_insert) + count($contacts_to_update) + count($contacts_already_updated),
            ]
        );
    }

    public function popClient()
    {

        // Same but with Client

        $queryClient = 'SELECT TOP 100000 *  FROM  "Client"';
        $prep = $this->conn->prepare($queryClient);
        $prep->execute();
        $clients_mssql = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate Client

        //        $AllClients = Client::all();

        //        dd($AllClients->where('Codecli', '515')->first());

        $clients_to_insert = [];
        $clients_to_update = [];
        $clients_already_updated = [];

        foreach ($clients_mssql as $client_mssql) {
            // check if client exist
            $client = Client::where('Codecli', $client_mssql['Codecli'])->first();
            //            $client = $AllClients->firstWhere('Codecli', $client_mssql['Codecli']);
            //            dd($client);
            //            $client = $AllClients->filter(function ($value, $key) use ($client_mssql) {
            //                return $value->Codecli == $client_mssql['Codecli'];
            //            })->first();
            if (! $client) {
                $client = new Client();
                $client->Codecli = $client_mssql['Codecli'];
                $client->reftr = $client_mssql['RefTR'];
                $client->nom = $client_mssql['Nom'];
                $client->rue = $client_mssql['Rue'];
                $client->codepays = $client_mssql['CodePays'];
                $client->codepost = $client_mssql['CodePost'];
                $client->tel = $client_mssql['Tel'];
                $client->fax = $client_mssql['Fax'];
                $client->refcli = $client_mssql['RefCli'];
                $client->respimm = $client_mssql['Respimm'];
                $client->gerant = $client_mssql['Gerant'];
                $client->rueger = $client_mssql['RueGer'];
                $client->codepaysger = $client_mssql['CodePaysGer'];
                $client->codepostger = $client_mssql['CodePostGer'];
                $client->telger = $client_mssql['TelGer'];
                $client->faxger = $client_mssql['FaxGer'];
                $client->devise = $client_mssql['Devise'];
                $client->remarque = $client_mssql['Remarque'];
                $client->datefin = $client_mssql['datefin'];
                $client->dernierreleve = $client_mssql['DernierReleve'];
                $client->adk = $client_mssql['ADK'];
                $client->codlngdec = $client_mssql['CodLngDec'];
                $client->codfichier = $client_mssql['CodFichier'];
                $client->codegerant = $client_mssql['CodeGerant'];

                $clients_to_insert[] = $client;

            } else {
                $clientModified = false;
                // update existing client

                if ($client->reftr != $client_mssql['RefTR']) {
                    $client->reftr = $client_mssql['RefTR'];
                    $clientModified = true;
                }

                if ($client->nom != $client_mssql['Nom']) {
                    $client->nom = $client_mssql['Nom'];
                    $clientModified = true;
                }

                if ($client->rue != $client_mssql['Rue']) {
                    $client->rue = $client_mssql['Rue'];
                    $clientModified = true;
                }

                if ($client->codepays != $client_mssql['CodePays']) {
                    $client->codepays = $client_mssql['CodePays'];
                    $clientModified = true;
                }

                if ($client->codepost != $client_mssql['CodePost']) {
                    $client->codepost = $client_mssql['CodePost'];
                    $clientModified = true;
                }

                if ($client->tel != $client_mssql['Tel']) {
                    $client->tel = $client_mssql['Tel'];
                    $clientModified = true;
                }

                if ($client->fax != $client_mssql['Fax']) {
                    $client->fax = $client_mssql['Fax'];
                    $clientModified = true;
                }

                if ($client->refcli != $client_mssql['RefCli']) {
                    $client->refcli = $client_mssql['RefCli'];
                    $clientModified = true;
                }

                if ($client->respimm != $client_mssql['Respimm']) {
                    $client->respimm = $client_mssql['Respimm'];
                    $clientModified = true;
                }

                if ($client->gerant != $client_mssql['Gerant']) {
                    $client->gerant = $client_mssql['Gerant'];
                    $clientModified = true;
                }

                if ($client->rueger != $client_mssql['RueGer']) {
                    $client->rueger = $client_mssql['RueGer'];
                    $clientModified = true;
                }

                if ($client->codepaysger != $client_mssql['CodePaysGer']) {
                    $client->codepaysger = $client_mssql['CodePaysGer'];
                    $clientModified = true;
                }

                if ($client->codepostger != $client_mssql['CodePostGer']) {
                    $client->codepostger = $client_mssql['CodePostGer'];
                    $clientModified = true;
                }

                if ($client->telger != $client_mssql['TelGer']) {
                    $client->telger = $client_mssql['TelGer'];
                    $clientModified = true;
                }

                if ($client->faxger != $client_mssql['FaxGer']) {
                    $client->faxger = $client_mssql['FaxGer'];
                    $clientModified = true;
                }

                if ($client->devise != $client_mssql['Devise']) {
                    $client->devise = $client_mssql['Devise'];
                    $clientModified = true;
                }

                if ($client->remarque != $client_mssql['Remarque']) {
                    $client->remarque = $client_mssql['Remarque'];
                    $clientModified = true;
                }

                if ($client->datefin != $client_mssql['datefin']) {
                    $client->datefin = $client_mssql['datefin'];
                    $clientModified = true;
                }

                if ($client->dernierreleve != $client_mssql['DernierReleve']) {
                    $client->dernierreleve = $client_mssql['DernierReleve'];
                    $clientModified = true;
                }

                if ($client->adk != $client_mssql['ADK']) {
                    $client->adk = $client_mssql['ADK'];
                    $clientModified = true;
                }

                if ($client->codlngdec != $client_mssql['CodLngDec']) {
                    $client->codlngdec = $client_mssql['CodLngDec'];
                    $clientModified = true;
                }

                if ($client->codfichier != $client_mssql['CodFichier']) {
                    $client->codfichier = $client_mssql['CodFichier'];
                    $clientModified = true;
                }

                if ($client->codegerant != $client_mssql['CodeGerant']) {
                    $client->codegerant = $client_mssql['CodeGerant'];
                    $clientModified = true;
                }

                if ($clientModified) {
                    $clients_to_update[] = $client;
                } else {
                    $clients_already_updated[] = $client;
                }
            }

        }

        // insert clients
        foreach ($clients_to_insert as $client_to_insert) {
            $client_to_insert->save();
        }

        // update clients
        foreach ($clients_to_update as $client_to_update) {
            $client_to_update->save();
        }

        //        var_dump('ok',
        //            '<br>clients_to_insert: ' . count($clients_to_insert),
        //            '<br>clients_to_update: ' . count($clients_to_update),
        //            '<br>clients_already_updated: ' . count($clients_already_updated));

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Client',
                'itemInsert' => count($clients_to_insert),
                'itemUpdate' => count($clients_to_update),
                'itemUnchanged' => count($clients_already_updated),
                'itemTotal' => count($clients_to_insert) + count($clients_to_update) + count($clients_already_updated),
            ]
        );

    }

    public function popAppartement()
    {
        // Same but with Property

        $queryAppartement = 'SELECT TOP 100000 *  FROM  "Appartement"';
        $prep = $this->conn->prepare($queryAppartement);
        $prep->execute();
        $appartements_mssql = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate Appartement

        $appartements_to_insert = [];
        $appartements_to_update = [];
        $appartements_already_updated = [];

        foreach ($appartements_mssql as $appartement_mssql) {
            // check if appartement exist
            $appartement = Appartement::where([
                ['Codecli', '=', $appartement_mssql['Codecli']],
                ['RefAppTR', '=', $appartement_mssql['RefAppTR']],
                ['RefAppCli', '=', $appartement_mssql['RefAppCli']],
            ])->first();

            if (! $appartement) {
                $appartement = new Appartement();
                $appartement->Codecli = $appartement_mssql['Codecli'];
                $appartement->RefAppTR = $appartement_mssql['RefAppTR'];
                $appartement->DesApp = $appartement_mssql['DesApp'];
                $appartement->RefAppCli = $appartement_mssql['RefAppCli'];
                $appartement->datefin = $appartement_mssql['datefin'];
                $appartement->lancod = $appartement_mssql['lancod'];
                $appartement->bloc = $appartement_mssql['bloc'];
                $appartement->proprietaire = $appartement_mssql['proprietaire'];
                $appartement->Cellule = $appartement_mssql['Cellule'];

                $appartements_to_insert[] = $appartement;

            } else {
                $appartementModified = false;
                // update existing appartement

                //                if ($appartement->RefAppTR != $appartement_mssql['RefAppTR']) {
                //                    $appartement->RefAppTR = $appartement_mssql['RefAppTR'];
                //                    $appartementModified = true;
                //                }

                if ($appartement->DesApp != $appartement_mssql['DesApp']) {
                    $appartement->DesApp = $appartement_mssql['DesApp'];
                    $appartementModified = true;
                }

                //                if ($appartement->RefAppCli != $appartement_mssql['RefAppCli']) {
                //                    $appartement->RefAppCli = $appartement_mssql['RefAppCli'];
                //                    $appartementModified = true;
                //                }

                if ($appartement->datefin != $appartement_mssql['datefin']) {
                    $appartement->datefin = $appartement_mssql['datefin'];
                    $appartementModified = true;
                }

                if ($appartement->lancod != $appartement_mssql['lancod']) {
                    $appartement->lancod = $appartement_mssql['lancod'];
                    $appartementModified = true;
                }

                if ($appartement->bloc != $appartement_mssql['bloc']) {
                    $appartement->bloc = $appartement_mssql['bloc'];
                    $appartementModified = true;
                }

                if ($appartement->proprietaire != $appartement_mssql['proprietaire']) {
                    $appartement->proprietaire = $appartement_mssql['proprietaire'];
                    $appartementModified = true;
                }

                if ($appartement->Cellule != $appartement_mssql['Cellule']) {
                    $appartement->Cellule = $appartement_mssql['Cellule'];
                    $appartementModified = true;
                }

                if ($appartementModified) {
                    $appartements_to_update[] = $appartement;
                } else {
                    $appartements_already_updated[] = $appartement;
                }

            }
        }

        // insert appartements

        foreach ($appartements_to_insert as $appartement_to_insert) {
            $appartement_to_insert->save();
        }

        // update appartements

        foreach ($appartements_to_update as $appartement_to_update) {
            $appartement_to_update->save();
        }

        //        var_dump('ok',
        //            '<br>appartements_to_insert: ' . count($appartements_to_insert),
        //            '<br>appartements_to_update: ' . count($appartements_to_update),
        //            '<br>appartements_already_updated: ' . count($appartements_already_updated));

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Appartement',
                'itemInsert' => count($appartements_to_insert),
                'itemUpdate' => count($appartements_to_update),
                'itemUnchanged' => count($appartements_already_updated),
                'itemTotal' => count($appartements_to_insert) + count($appartements_to_update) + count($appartements_already_updated),
            ]
        );
    }

    public function popGerantImm()
    {
        $queryGerantImm = 'SELECT TOP 100000 *  FROM  "Gerant-Imm"';
        $prep = $this->conn->prepare($queryGerantImm);
        $prep->execute();

        $gerantImms_mssql = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate GerantImm

        $gerantImms_to_insert = [];
        $gerantImms_to_update = [];
        $gerantImms_already_updated = [];

        //        dd($gerantImms_mssql);

        foreach ($gerantImms_mssql as $gerantImm_mssql) {
            // check if gerantImm exist
            $gerantImm = GerantImm::where('Codegerant', $gerantImm_mssql['Codegerant'])->first();
            if (! $gerantImm) {
                $gerantImm = new GerantImm();
                $client = Client::where('Codecli', $gerantImm_mssql['Codecli'])->first();
                $gerantImm->client()->associate($client);
                //                $gerantImm->Codecli = $gerantImm_mssql['Codecli'];
                $gerantImm->codegerant = $gerantImm_mssql['Codegerant'];
                $gerantImm->datdeb = $gerantImm_mssql['DatDeb'];
                $gerantImm->acces = $gerantImm_mssql['Acces'];
                $gerantImm->datfin = $gerantImm_mssql['DatFin'];

                $gerantImms_to_insert[] = $gerantImm;
            //                $gerantImm->save();
            //                if ($gerantImm_mssql['Codecli'] != '0')
            //                {
            //                    dd($client, $gerantImm, $gerantImm_mssql);
            //                }

            } else {
                $gerantImmModified = false;
                // update existing gerantImm

                $client = Client::where('Codecli', $gerantImm_mssql['Codecli'])->first();

                if ($gerantImm->Codecli != $gerantImm_mssql['Codecli']) {
                    $gerantImm->client()->sync($client);
                    $gerantImmModified = true;
                }

                if ($gerantImm->datdeb != $gerantImm_mssql['DatDeb']) {
                    $gerantImm->datdeb = $gerantImm_mssql['DatDeb'];
                    $gerantImmModified = true;
                }

                if ($gerantImm->acces != $gerantImm_mssql['Acces']) {
                    $gerantImm->acces = $gerantImm_mssql['Acces'];
                    $gerantImmModified = true;
                }

                if ($gerantImm->datfin != $gerantImm_mssql['DatFin']) {
                    $gerantImm->datfin = $gerantImm_mssql['DatFin'];
                    $gerantImmModified = true;
                }

                if ($gerantImmModified) {
                    $gerantImms_to_update[] = $gerantImm;
                } else {
                    $gerantImms_already_updated[] = $gerantImm;
                }

            }
        }

        // insert gerantImms

        foreach ($gerantImms_to_insert as $gerantImm_to_insert) {
            $gerantImm_to_insert->save();
        }

        // update gerantImms

        foreach ($gerantImms_to_update as $gerantImm_to_update) {
            $gerantImm_to_update->save();
        }

        //        var_dump('ok',
        //            '<br>gerantImms_to_insert: ' . count($gerantImms_to_insert),
        //            '<br>gerantImms_to_update: ' . count($gerantImms_to_update),
        //            '<br>gerantImms_already_updated: ' . count($gerantImms_already_updated));
        //
        //
        //        dd('STOP');

        return view('admin.sync.syncdata',
            [
                'dataName' => 'GerantImm',
                'itemInsert' => count($gerantImms_to_insert),
                'itemUpdate' => count($gerantImms_to_update),
                'itemUnchanged' => count($gerantImms_already_updated),
                'itemTotal' => count($gerantImms_to_insert) + count($gerantImms_to_update) + count($gerantImms_already_updated),
            ]
        );
    }

    public function popRelApp()
    {
        $querySQL1 = 'SELECT TOP 1000000 *  FROM  "Relapp"';
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relApps = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relApp

        $relApps_to_insert = [];
        $relApps_to_update = [];
        $relApps_already_updated = [];

        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        foreach ($relApps as $relApp) {
            // check if relApp exist + load client
            $client = Client::where('Codecli', $relApp['Codecli'])->first();
            //            dd($client, $relApp, $relApp['Codecli']);
            $exist_RelApp = RelApp::where([
                ['Codecli', '=', $relApp['Codecli']],
                ['RefAppTR', '=', $relApp['RefAppTR']],
                ['DatRel', '=', $relApp['DatRel']],
                //                ['CleProv', '=', $relApp['CleProv']],
                //                ['ProprioCd', '=', $relApp['ProprioCd']],
                //                ['LocatCd', '=', $relApp['LocatCd']
            ])->first();

            if (! $exist_RelApp && $client) {
                $relApp_new = new RelApp();
                $relApp_new->client()->associate($client);
                $relApp_new->RefAppTR = $relApp['RefAppTR'];
                //                $relApp_new->Codecli = $relApp['Codecli'];
                $relApp_new->MtProv = $relApp['MtProv'];
                $relApp_new->DatRel = $relApp['DatRel'];
                $relApp_new->CleProv = $relApp['CleProv'];
                $relApp_new->ProprioCd = $relApp['ProprioCd'];
                $relApp_new->LocatCd = $relApp['LocatCd'];

                $relApps_to_insert[] = $relApp_new;
            } else {
                $relAppModified = false;
                // update existing relApp

                if ($exist_RelApp->MtProv != $relApp['MtProv']) {
                    $exist_RelApp->MtProv = $relApp['MtProv'];
                    $relAppModified = true;
                }

                if ($exist_RelApp->CleProv != $relApp['CleProv']) {
                    $exist_RelApp->CleProv = $relApp['CleProv'];
                    $relAppModified = true;
                }

                if ($exist_RelApp->ProprioCd != $relApp['ProprioCd']) {
                    $exist_RelApp->ProprioCd = $relApp['ProprioCd'];
                    $relAppModified = true;
                }

                if ($exist_RelApp->LocatCd != $relApp['LocatCd']) {
                    $exist_RelApp->LocatCd = $relApp['LocatCd'];
                    $relAppModified = true;
                }

                if ($relAppModified) {
                    $relApps_to_update[] = $exist_RelApp;
                } else {
                    $relApps_already_updated[] = $exist_RelApp;
                }

            }
        }

        // insert relApps

        foreach ($relApps_to_insert as $relApp_to_insert) {
            $relApp_to_insert->save();
        }

        // update relApps

        foreach ($relApps_to_update as $relApp_to_update) {
            $relApp_to_update->save();
        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Contact',
                'itemInsert' => count($relApps_to_insert),
                'itemUpdate' => count($relApps_to_update),
                'itemUnchanged' => count($relApps_already_updated),
                'itemTotal' => count($relApps_to_insert) + count($relApps_to_update) + count($relApps_already_updated),
            ]
        );
    }

    public function popCodePostelb()
    {
        $querySQL1 = 'SELECT TOP 1000000 *  FROM  "Code-Postelb"';
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $codePostelbs = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate codePostelb

        $codePostelbs_to_insert = [];
        $codePostelbs_to_update = [];
        $codePostelbs_already_updated = [];

        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        //        dd($codePostelbs);
        foreach ($codePostelbs as $codePostelb) {
            // check if codePostelb exist
            $exist_codePostelb = \App\Models\CodePostelb::where([
                ['CodePays', '=', $codePostelb['CodePays']],
                ['codePost', '=', $codePostelb['codePost']],
                //                ['Localite', '=', $codePostelb['Localite']],
                ['Lancod', '=', $codePostelb['Lancod']],
            ])->first();

            if (! $exist_codePostelb) {
                $codePostelb_new = new \App\Models\CodePostelb();
                $codePostelb_new->CodePays = $codePostelb['CodePays'];
                $codePostelb_new->codePost = $codePostelb['codePost'];
                $codePostelb_new->Localite = $codePostelb['Localite'];
                $codePostelb_new->Lancod = $codePostelb['Lancod'];

                $codePostelbs_to_insert[] = $codePostelb_new;
                $codePostelb_new->save();

            } else {
                $codePostelbModified = false;
                // update existing codePostelb

                //                if ($exist_codePostelb->CodePays != $codePostelb['CodePays']) {
                //                    $exist_codePostelb->CodePays = $codePostelb['CodePays'];
                //                    $codePostelbModified = true;
                //                }
                //
                //                if ($exist_codePostelb->codePost != $codePostelb['codePost']) {
                //                    $exist_codePostelb->codePost = $codePostelb['codePost'];
                //                    $codePostelbModified = true;
                //                }

                if ($exist_codePostelb->Localite != $codePostelb['Localite']) {
                    $exist_codePostelb->Localite = $codePostelb['Localite'];
                    $codePostelbModified = true;
                }

                //                if ($exist_codePostelb->Lancod != $codePostelb['Lancod']) {
                //                    $exist_codePostelb->Lancod = $codePostelb['Lancod'];
                //                    $codePostelbModified = true;
                //                }

                if ($codePostelbModified) {
                    $codePostelbs_to_update[] = $exist_codePostelb;
                } else {
                    $codePostelbs_already_updated[] = $exist_codePostelb;
                }
            }
        }

        // insert codePostelbs

        //        foreach ($codePostelbs_to_insert as $codePostelb_to_insert) {
        //            $codePostelb_to_insert->save();
        //        }

        // update codePostelbs

        foreach ($codePostelbs_to_update as $codePostelb_to_update) {
            $codePostelb_to_update->save();
        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'CodePostelb',
                'itemInsert' => count($codePostelbs_to_insert),
                'itemUpdate' => count($codePostelbs_to_update),
                'itemUnchanged' => count($codePostelbs_already_updated),
                'itemTotal' => count($codePostelbs_to_insert) + count($codePostelbs_to_update) + count($codePostelbs_already_updated),
            ]
        );

    }

    public function popClichauff()
    {
        $querySQL1 = 'SELECT TOP 1000000 *  FROM  "Clichauf"';
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $clichauffs = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate clichauff

        $clichauffs_to_insert = [];
        $clichauffs_to_update = [];
        $clichauffs_already_updated = [];

        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        foreach ($clichauffs as $clichauff) {
            // check if clichauff exist
            $exist_clichauff = Clichauf::where([
                ['Codecli', '=', $clichauff['Codecli']],
            ])->first();

            if (! $exist_clichauff) {
                $clichauff_new = new Clichauf();
                $clichauff_new->Codecli = $clichauff['Codecli'];
                $clichauff_new->Quotite = $clichauff['Quotite'];
                $clichauff_new->PctPrive = $clichauff['PctPrive'];
                $clichauff_new->PctCom = $clichauff['PctCom'];
                $clichauff_new->TypCal = $clichauff['TypCal'];
                $clichauff_new->FraisTR = $clichauff['FraisTR'];
                $clichauff_new->FraisAnn = $clichauff['FraisAnn'];
                $clichauff_new->Consom = $clichauff['Consom'];
                $clichauff_new->Periode = $clichauff['Periode'];
                $clichauff_new->UniteAnn = $clichauff['UniteAnn'];
                $clichauff_new->TypRep = $clichauff['TypRep'];
                $clichauff_new->ConsPrive = $clichauff['ConsPrive'];
                $clichauff_new->ConsComm = $clichauff['ConsComm'];
                $clichauff_new->TypRlv = $clichauff['TypRlv'];
                $clichauff_new->DatePlacement = $clichauff['DatePlacement'];

                $clichauffs_to_insert[] = $clichauff_new;

                $client_id = Client::where('Codecli', $clichauff['Codecli'])->first();

                if ($client_id) {
                    $clichauff_new->client()->associate($client_id);
                }

                $clichauff_new->save();

            } else {
                $clichauffModified = false;
                // update existing clichauff

                //                if ($exist_clichauff->Codecli != $clichauff['Codecli']) {
                //                    $exist_clichauff->Codecli = $clichauff['Codecli'];
                //                    $clichauffModified = true;
                //                }

                if ($exist_clichauff->Quotite != $clichauff['Quotite']) {
                    $exist_clichauff->Quotite = $clichauff['Quotite'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->PctPrive != $clichauff['PctPrive']) {
                    $exist_clichauff->PctPrive = $clichauff['PctPrive'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->PctCom != $clichauff['PctCom']) {
                    $exist_clichauff->PctCom = $clichauff['PctCom'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->TypCal != $clichauff['TypCal']) {
                    $exist_clichauff->TypCal = $clichauff['TypCal'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->FraisTR != $clichauff['FraisTR']) {
                    $exist_clichauff->FraisTR = $clichauff['FraisTR'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->FraisAnn != $clichauff['FraisAnn']) {
                    $exist_clichauff->FraisAnn = $clichauff['FraisAnn'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->Consom != $clichauff['Consom']) {
                    $exist_clichauff->Consom = $clichauff['Consom'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->Periode != $clichauff['Periode']) {
                    $exist_clichauff->Periode = $clichauff['Periode'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->UniteAnn != $clichauff['UniteAnn']) {
                    $exist_clichauff->UniteAnn = $clichauff['UniteAnn'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->TypRep != $clichauff['TypRep']) {
                    $exist_clichauff->TypRep = $clichauff['TypRep'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->ConsPrive != $clichauff['ConsPrive']) {
                    $exist_clichauff->ConsPrive = $clichauff['ConsPrive'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->ConsComm != $clichauff['ConsComm']) {
                    $exist_clichauff->ConsComm = $clichauff['ConsComm'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->TypRlv != $clichauff['TypRlv']) {
                    $exist_clichauff->TypRlv = $clichauff['TypRlv'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->DatePlacement != $clichauff['DatePlacement']) {
                    $exist_clichauff->DatePlacement = $clichauff['DatePlacement'];
                    $clichauffModified = true;
                }

                if ($exist_clichauff->client_id == null) {
                    $client_id = Client::where('Codecli', $clichauff['Codecli'])->first();
                    $clichauffModified = true;
                }

                if ($clichauffModified) {
                    $clichauffs_to_update[] = $exist_clichauff;
                    if ($exist_clichauff->client_id == null) {
                        $exist_clichauff->client()->associate($client_id);
                        $exist_clichauff->save();
                    } else {
                        $exist_clichauff->save();
                    }
                } else {
                    $clichauffs_already_updated[] = $exist_clichauff;
                }

            }
        }

        // insert clichauffs

        //        foreach ($clichauffs_to_insert as $clichauff_to_insert) {
        //            $clichauff_to_insert->save();
        //        }

        // update clichauffs

        //        foreach ($clichauffs_to_update as $clichauff_to_update) {
        //            $clichauff_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Clichauff',
                'itemInsert' => count($clichauffs_to_insert),
                'itemUpdate' => count($clichauffs_to_update),
                'itemUnchanged' => count($clichauffs_already_updated),
                'itemTotal' => count($clichauffs_to_insert) + count($clichauffs_to_update) + count($clichauffs_already_updated),
            ]
        );
    }

    public function popCliEau()
    {
        $querySQL1 = 'SELECT TOP 1000000 *  FROM  "CliEau"';
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $clicheaus = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate clicheau

        $clicheaus_to_insert = [];
        $clicheaus_to_update = [];
        $clicheaus_already_updated = [];
        //        dd($clicheaus);

        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        foreach ($clicheaus as $clicheau) {
            // check if clicheau exist
            $exist_clicheau = CliEau::where([
                ['Codecli', '=', $clicheau['Codecli']],
            ])->first();

            if (! $exist_clicheau) {
                $clicheau_new = new CliEau();
                $clicheau_new->Codecli = $clicheau['Codecli'];
                $clicheau_new->PrxFroid = $clicheau['PrxFroid'];
                $clicheau_new->PrxChaud = $clicheau['PrxChaud'];
                $clicheau_new->TypCpt = $clicheau['TypCpt'];
                $clicheau_new->FraisTR = $clicheau['FraisTR'];
                $clicheau_new->FraisAnn = $clicheau['FraisAnn'];
                $clicheau_new->Consom = $clicheau['Consom'];
                $clicheau_new->Unite = $clicheau['Unite'];
                $clicheau_new->SupChaud = $clicheau['SupChaud'];
                $clicheau_new->Periode = $clicheau['Periode'];
                $clicheau_new->typcalc_ = $clicheau['typcalc_'];
                $clicheau_new->UnitAnn = $clicheau['UnitAnn'];
                $clicheau_new->typcalc = $clicheau['typcalc'];
                $clicheau_new->ChaudChf = $clicheau['ChaudChf'];
                $clicheau_new->EauSol = $clicheau['EauSol'];
                $clicheau_new->TypRlv = $clicheau['TypRlv'];
                $clicheau_new->DatePlacement = $clicheau['DatePlacement'];

                $clicheaus_to_insert[] = $clicheau_new;
                $clicheau_new->save();

            } else {
                $clicheauModified = false;
                // update existing clicheau

                if ($exist_clicheau->PrxFroid != $clicheau['PrxFroid']) {
                    $exist_clicheau->PrxFroid = $clicheau['PrxFroid'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->PrxChaud != $clicheau['PrxChaud']) {
                    $exist_clicheau->PrxChaud = $clicheau['PrxChaud'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->TypCpt != $clicheau['TypCpt']) {
                    $exist_clicheau->TypCpt = $clicheau['TypCpt'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->FraisTR != $clicheau['FraisTR']) {
                    $exist_clicheau->FraisTR = $clicheau['FraisTR'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->FraisAnn != $clicheau['FraisAnn']) {
                    $exist_clicheau->FraisAnn = $clicheau['FraisAnn'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->Consom != $clicheau['Consom']) {
                    $exist_clicheau->Consom = $clicheau['Consom'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->Unite != $clicheau['Unite']) {
                    $exist_clicheau->Unite = $clicheau['Unite'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->SupChaud != $clicheau['SupChaud']) {
                    $exist_clicheau->SupChaud = $clicheau['SupChaud'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->Periode != $clicheau['Periode']) {
                    $exist_clicheau->Periode = $clicheau['Periode'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->typcalc_ != $clicheau['typcalc_']) {
                    $exist_clicheau->typcalc_ = $clicheau['typcalc_'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->UnitAnn != $clicheau['UnitAnn']) {
                    $exist_clicheau->UnitAnn = $clicheau['UnitAnn'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->typcalc != $clicheau['typcalc']) {
                    $exist_clicheau->typcalc = $clicheau['typcalc'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->ChaudChf != $clicheau['ChaudChf']) {
                    $exist_clicheau->ChaudChf = $clicheau['ChaudChf'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->EauSol != $clicheau['EauSol']) {
                    $exist_clicheau->EauSol = $clicheau['EauSol'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->TypRlv != $clicheau['TypRlv']) {
                    $exist_clicheau->TypRlv = $clicheau['TypRlv'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->DatePlacement != $clicheau['DatePlacement']) {
                    $exist_clicheau->DatePlacement = $clicheau['DatePlacement'];
                    $clicheauModified = true;
                }

                if ($exist_clicheau->client_id == null) {
                    $client_id = Client::where('Codecli', $clicheau['Codecli'])->first();
                    $clicheauModified = true;
                }

                if ($clicheauModified) {
                    $clicheaus_to_update[] = $exist_clicheau;
                    if ($exist_clicheau->client_id == null) {
                        $exist_clicheau->client()->associate($client_id);
                        $exist_clicheau->save();
                    } else {
                        $exist_clicheau->save();
                    }
                } else {
                    $clicheaus_already_updated[] = $exist_clicheau;
                }

            }
        }

        // insert clicheaus

        //        foreach ($clicheaus_to_insert as $clicheau_to_insert) {
        //            $clicheau_to_insert->save();
        //        }

        // update clicheaus

        //        foreach ($clicheaus_to_update as $clicheau_to_update) {
        //            $clicheau_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'CliEau',
                'itemInsert' => count($clicheaus_to_insert),
                'itemUpdate' => count($clicheaus_to_update),
                'itemUnchanged' => count($clicheaus_already_updated),
                'itemTotal' => count($clicheaus_to_insert) + count($clicheaus_to_update) + count($clicheaus_already_updated),
            ]
        );

    }

    public function popRelClientsPosteCode()
    {
        // create relation between Client and code_postelb

        $allClients = Client::all();

        $items_updated = 0;

        foreach ($allClients as $client) {
            $code_postelb = CodePostelb::where('codePost', $client->codepost)->first();
            if ($code_postelb) {

                $client->codePostelbs()->sync($code_postelb);
                $client->save();
                $items_updated++;
            }
        }

        return view('admin.sync.syncdata',
            [
                'dataName' => 'Client',
                'itemInsert' => 0,
                'itemUpdate' => $items_updated,
                'itemUnchanged' => 0,
                'itemTotal' => $items_updated,
            ]
        );

    }

    public function popRelradChf()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(12000);

        $querySQL1 = 'SELECT TOP 100000000 *  FROM  "RelRad-Chf"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relradChfs = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relradChf

        $relradChfs_to_insert = [];
        $relradChfs_to_update = [];
        $relradChfs_already_updated = [];

        foreach ($relradChfs as $relradChf) {
            // check if relradChf exist
            $exist_relradChf = RelRadChf::where([
                ['id', '=', $relradChf['ID']],
                //                ['Codecli', '=', $relradChf['Codecli']],
                //                ['RefAppTR', '=', $relradChf['RefAppTR']],
                //                ['DatRel', '=', $relradChf['DatRel']],
                //                ['Numcal', '=', $relradChf['Numcal']],
                //                ['Nvidx', '=', $relradChf['Nvidx']],
                //                ['StatutImp', '=', $relradChf['StatutImp']],
                //                ['DatRelFich', '=', $relradChf['DatRelFich']],
                //                ['FileName', '=', $relradChf['FileName']],
                //                ['NumImp', '=', $relradChf['NumImp']],
                //                ['Erreur', '=', $relradChf['Erreur']],
                //                ['StatutRel', '=', $relradChf['StatutRel']],
                //                ['RelPrinc', '=', $relradChf['RelPrinc']],
                //                ['DatImp', '=', $relradChf['DatImp']],
                //                ['hh-imp', '=', $relradChf['hh-imp']],
                //                ['mm-imp', '=', $relradChf['mm-imp']],
                //                ['Ok-Site', '=', $relradChf['Ok-Site']],
                //                ['Coef', '=', $relradChf['Coef']],
                //                ['AncIdx', '=', $relradChf['AncIdx']],
            ])->first();

            if (! $exist_relradChf) {
                $relradChf_new = new RelRadChf();
                //                $relradChf_new->Codecli = $relradChf['Codecli'];
                $relradChf_new->id = $relradChf['ID'];
                $relradChf_new->RefAppTR = $relradChf['RefAppTR'];
                $relradChf_new->DatRel = $relradChf['DatRel'];
                $relradChf_new->Numcal = $relradChf['Numcal'];
                $relradChf_new->Nvidx = $relradChf['Nvidx'];
                $relradChf_new->StatutImp = $relradChf['StatutImp'];
                $relradChf_new->DatRelFich = $relradChf['DatRelFich'];
                $relradChf_new->FileName = $relradChf['FileName'];
                $relradChf_new->NumImp = $relradChf['NumImp'];
                $relradChf_new->Erreur = $relradChf['Erreur'];
                $relradChf_new->StatutRel = $relradChf['StatutRel'];
                $relradChf_new->RelPrinc = $relradChf['RelPrinc'];
                $relradChf_new->DatImp = $relradChf['DatImp'];
                $relradChf_new->hh_imp = $relradChf['hh-imp'];
                $relradChf_new->mm_imp = $relradChf['mm-imp'];
                $relradChf_new->Ok_Site = $relradChf['Ok-Site'];
                $relradChf_new->Coef = $relradChf['Coef'];
                $relradChf_new->AncIdx = $relradChf['AncIdx'];

                $client_id = Client::where('Codecli', $relradChf['Codecli'])->first();

                $relradChfs_to_insert[] = $relradChf_new;
                if ($client_id) {
                    $relradChf_new->client()->associate($client_id);
                }
                $relradChf_new->save();
            } else {
                $relradChfModified = false;
                // update existing relradChf

                //                if ($exist_relradChf->RefAppTR != $relradChf['RefAppTR']) {
                //                    $exist_relradChf->RefAppTR = $relradChf['RefAppTR'];
                //                    $relradChfModified = true;
                //                }
                //
                //                if ($exist_relradChf->DatRel != $relradChf['DatRel']) {
                //                    $exist_relradChf->DatRel = $relradChf['DatRel'];
                //                    $relradChfModified = true;
                //                }

                if ($exist_relradChf->Numcal != $relradChf['Numcal']) {
                    $exist_relradChf->Numcal = $relradChf['Numcal'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->Nvidx != $relradChf['Nvidx']) {
                    $exist_relradChf->Nvidx = $relradChf['Nvidx'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->StatutImp != $relradChf['StatutImp']) {
                    $exist_relradChf->StatutImp = $relradChf['StatutImp'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->DatRelFich != $relradChf['DatRelFich']) {
                    $exist_relradChf->DatRelFich = $relradChf['DatRelFich'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->FileName != $relradChf['FileName']) {
                    $exist_relradChf->FileName = $relradChf['FileName'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->NumImp != $relradChf['NumImp']) {
                    $exist_relradChf->NumImp = $relradChf['NumImp'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->Erreur != $relradChf['Erreur']) {
                    $exist_relradChf->Erreur = $relradChf['Erreur'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->StatutRel != $relradChf['StatutRel']) {
                    $exist_relradChf->StatutRel = $relradChf['StatutRel'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->RelPrinc != $relradChf['RelPrinc']) {
                    $exist_relradChf->RelPrinc = $relradChf['RelPrinc'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->DatImp != $relradChf['DatImp']) {
                    $exist_relradChf->DatImp = $relradChf['DatImp'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->hh_imp != $relradChf['hh-imp']) {
                    $exist_relradChf->hh_imp = $relradChf['hh-imp'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->mm_imp != $relradChf['mm-imp']) {
                    $exist_relradChf->mm_imp = $relradChf['mm-imp'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->Ok_Site != $relradChf['Ok-Site']) {
                    $exist_relradChf->Ok_Site = $relradChf['Ok-Site'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->Coef != $relradChf['Coef']) {
                    $exist_relradChf->Coef = $relradChf['Coef'];
                    $relradChfModified = true;
                }

                if ($exist_relradChf->AncIdx != $relradChf['AncIdx']) {
                    $exist_relradChf->AncIdx = $relradChf['AncIdx'];
                    $relradChfModified = true;
                }

                if ($relradChfModified) {
                    $relradChfs_to_update[] = $exist_relradChf;
                    if ($exist_relradChf->client_id == null) {
                        $client_id = Client::where('Codecli', $relradChf['Codecli'])->first();
                        $relradChfModified = true;
                    }
                    if ($relradChfModified) {
                        $relradChfs_to_update[] = $exist_relradChf;
                        if ($exist_relradChf->client_id == null) {
                            $exist_relradChf->client()->associate($client_id);
                            $exist_relradChf->save();
                        } else {
                            $exist_relradChf->save();
                        }
                    } else {
                        $relradChfs_already_updated[] = $exist_relradChf;
                    }
                }

            }
        }

        // insert relradChfs

        //        foreach ($relradChfs_to_insert as $relradChf_to_insert) {
        //            $relradChf_to_insert->save();
        //        }

        // update relradChfs

        //        foreach ($relradChfs_to_update as $relradChf_to_update) {
        //            $relradChf_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelRadChf',
                'itemInsert' => count($relradChfs_to_insert),
                'itemUpdate' => count($relradChfs_to_update),
                'itemUnchanged' => count($relradChfs_already_updated),
                'itemTotal' => count($relradChfs_to_insert) + count($relradChfs_to_update) + count($relradChfs_already_updated),
            ]
        );

    }

    //Table: RelRad-Eau
    //ID	int
    //Codecli	decimal(18, 0)	 nullable
    //RefAppTR	int	 nullable
    //DatRel	varchar(50)	 nullable
    //Numcal	varchar(16)	 nullable
    //Nvidx	decimal(18, 2)	 nullable
    //StatutImp	varchar(16)	 nullable
    //DatRelFich	varchar(50)	 nullable
    //FileName	varchar(122)	 nullable
    //NumImp	int	 nullable
    //Erreur	varchar(46)	 nullable
    //StatutRel	varchar(20)	 nullable
    //RelPrinc	tinyint	 nullable
    //DatImp	varchar(50)	 nullable
    //[hh-imp]	int	 nullable
    //[mm-imp]	int	 nullable
    //[Ok-Site]	tinyint	 nullable
    //[Ch-Fr]	varchar(4)	 nullable
    //AncIdx	decimal(18, 2)	 nullable

    public function popRelradEau()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(100000000);

        $querySQL1 = 'SELECT TOP 20000 *  FROM  "RelRad-Eau"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relradEaus = $prep->fetchAll(PDO::FETCH_ASSOC);

        //        dd($relradEaus);
        // Populate relradEau

        $relradEaus_to_insert = [];
        $relradEaus_to_update = [];
        $relradEaus_already_updated = [];

        foreach ($relradEaus as $relradEau) {
            // check if relradEau exist
            $exist_relradEau = RelRadEau::where([
                ['id', '=', $relradEau['ID']],
            ])->first();

            if (! $exist_relradEau) {
                $relradEau_new = new RelRadEau();
                $relradEau_new->id = $relradEau['ID'];
                $relradEau_new->RefAppTR = $relradEau['RefAppTR'];
                $relradEau_new->DatRel = $relradEau['DatRel'];
                $relradEau_new->Numcal = $relradEau['Numcal'];
                $relradEau_new->Nvidx = $relradEau['Nvidx'];
                $relradEau_new->StatutImp = $relradEau['StatutImp'];
                $relradEau_new->DatRelFich = $relradEau['DatRelFich'];
                $relradEau_new->FileName = $relradEau['FileName'];
                $relradEau_new->NumImp = $relradEau['NumImp'];
                $relradEau_new->Erreur = $relradEau['Erreur'];
                $relradEau_new->StatutRel = $relradEau['StatutRel'];
                $relradEau_new->RelPrinc = $relradEau['RelPrinc'];
                $relradEau_new->DatImp = $relradEau['DatImp'];
                $relradEau_new->hh_imp = $relradEau['hh-imp'];
                $relradEau_new->mm_imp = $relradEau['mm-imp'];
                $relradEau_new->Ok_Site = $relradEau['Ok-Site'];
                $relradEau_new->Ch_Fr = $relradEau['Ch-Fr'];
                $relradEau_new->AncIdx = $relradEau['AncIdx'];

                $client_id = Client::where('Codecli', $relradEau['Codecli'])->first();

                $relradEaus_to_insert[] = $relradEau_new;
                if ($client_id) {
                    $relradEau_new->client()->associate($client_id);
                }
                $relradEau_new->save();
            } else {
                $relradEauModified = false;
                // update existing relradEau

                if ($exist_relradEau->RefAppTR != $relradEau['RefAppTR']) {
                    $exist_relradEau->RefAppTR = $relradEau['RefAppTR'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->DatRel != $relradEau['DatRel']) {
                    $exist_relradEau->DatRel = $relradEau['DatRel'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->Numcal != $relradEau['Numcal']) {
                    $exist_relradEau->Numcal = $relradEau['Numcal'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->Nvidx != $relradEau['Nvidx']) {
                    $exist_relradEau->Nvidx = $relradEau['Nvidx'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->StatutImp != $relradEau['StatutImp']) {
                    $exist_relradEau->StatutImp = $relradEau['StatutImp'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->DatRelFich != $relradEau['DatRelFich']) {
                    $exist_relradEau->DatRelFich = $relradEau['DatRelFich'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->FileName != $relradEau['FileName']) {
                    $exist_relradEau->FileName = $relradEau['FileName'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->NumImp != $relradEau['NumImp']) {
                    $exist_relradEau->NumImp = $relradEau['NumImp'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->Erreur != $relradEau['Erreur']) {
                    $exist_relradEau->Erreur = $relradEau['Erreur'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->StatutRel != $relradEau['StatutRel']) {
                    $exist_relradEau->StatutRel = $relradEau['StatutRel'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->RelPrinc != $relradEau['RelPrinc']) {
                    $exist_relradEau->RelPrinc = $relradEau['RelPrinc'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->DatImp != $relradEau['DatImp']) {
                    $exist_relradEau->DatImp = $relradEau['DatImp'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->hh_imp != $relradEau['hh-imp']) {
                    $exist_relradEau->hh_imp = $relradEau['hh-imp'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->mm_imp != $relradEau['mm-imp']) {
                    $exist_relradEau->mm_imp = $relradEau['mm-imp'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->Ok_Site != $relradEau['Ok-Site']) {
                    $exist_relradEau->Ok_Site = $relradEau['Ok-Site'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->Ch_Fr != $relradEau['Ch-Fr']) {
                    $exist_relradEau->Ch_Fr = $relradEau['Ch-Fr'];
                    $relradEauModified = true;
                }

                if ($exist_relradEau->AncIdx != $relradEau['AncIdx']) {
                    $exist_relradEau->AncIdx = $relradEau['AncIdx'];
                    $relradEauModified = true;
                }

                if ($relradEauModified) {
                    $relradEaus_to_update[] = $exist_relradEau;
                    if ($exist_relradEau->client_id == null) {
                        $client_id = Client::where('Codecli', $relradEau['Codecli'])->first();
                        $exist_relradEau->client()->associate($client_id);
                        $exist_relradEau->save();
                    } else {
                        $exist_relradEau->save();
                    }
                } else {
                    $relradEaus_already_updated[] = $exist_relradEau;
                }
            }
        }

        // insert relradEaus

        //        foreach ($relradEaus_to_insert as $relradEau_to_insert) {
        //            $relradEau_to_insert->save();
        //        }

        // update relradEaus

        //        foreach ($relradEaus_to_update as $relradEau_to_update) {
        //            $relradEau_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelRadEau',
                'itemInsert' => count($relradEaus_to_insert),
                'itemUpdate' => count($relradEaus_to_update),
                'itemUnchanged' => count($relradEaus_already_updated),
                'itemTotal' => count($relradEaus_to_insert) + count($relradEaus_to_update) + count($relradEaus_already_updated),
            ]
        );
    }

    public function popRelChaufApp()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        $querySQL1 = 'SELECT TOP 100000000 *  FROM  "RelChaufApp"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relChaufApps = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relChaufApp

        $relChaufApps_to_insert = [];
        $relChaufApps_to_update = [];
        $relChaufApps_already_updated = [];

        foreach ($relChaufApps as $relChaufApp) {
            // check if relChaufApp exist
            $exist_relChaufApp = RelChaufApp::where([
                ['Codecli', '=', $relChaufApp['Codecli']],
                ['RefAppTR', '=', $relChaufApp['RefAppTR']],
                ['DatRel', '=', $relChaufApp['DatRel']],
            ])->first();

            if (! $exist_relChaufApp) {
                $relChaufApp_new = new RelChaufApp();
                $relChaufApp_new->Codecli = $relChaufApp['Codecli'];
                $relChaufApp_new->RefAppTR = $relChaufApp['RefAppTR'];
                $relChaufApp_new->DatRel = $relChaufApp['DatRel'];
                $relChaufApp_new->FraisDiv = $relChaufApp['FraisDiv'];
                $relChaufApp_new->Rem1 = $relChaufApp['Rem1'];
                $relChaufApp_new->Rem2 = $relChaufApp['Rem2'];
                $relChaufApp_new->NbRad = $relChaufApp['NbRad'];
                $relChaufApp_new->PctFraisAnn = $relChaufApp['PctFraisAnn'];
                $relChaufApp_new->RmqOcc = $relChaufApp['RmqOcc'];
                $relChaufApp_new->NbFraisTR = $relChaufApp['NbFraisTR'];
                $relChaufApp_new->AppQuot = $relChaufApp['AppQuot'];

                $client_id = Client::where('Codecli', $relChaufApp['Codecli'])->first();

                $relChaufApps_to_insert[] = $relChaufApp_new;
                if ($client_id) {
                    $relChaufApp_new->client()->associate($client_id);
                }
                $relChaufApp_new->save();
            } else {
                $relChaufAppModified = false;
                // update existing relChaufApp

                if ($exist_relChaufApp->FraisDiv != $relChaufApp['FraisDiv']) {
                    $exist_relChaufApp->FraisDiv = $relChaufApp['FraisDiv'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->Rem1 != $relChaufApp['Rem1']) {
                    $exist_relChaufApp->Rem1 = $relChaufApp['Rem1'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->Rem2 != $relChaufApp['Rem2']) {
                    $exist_relChaufApp->Rem2 = $relChaufApp['Rem2'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->NbRad != $relChaufApp['NbRad']) {
                    $exist_relChaufApp->NbRad = $relChaufApp['NbRad'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->PctFraisAnn != $relChaufApp['PctFraisAnn']) {
                    $exist_relChaufApp->PctFraisAnn = $relChaufApp['PctFraisAnn'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->RmqOcc != $relChaufApp['RmqOcc']) {
                    $exist_relChaufApp->RmqOcc = $relChaufApp['RmqOcc'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->NbFraisTR != $relChaufApp['NbFraisTR']) {
                    $exist_relChaufApp->NbFraisTR = $relChaufApp['NbFraisTR'];
                    $relChaufAppModified = true;
                }

                if ($exist_relChaufApp->AppQuot != $relChaufApp['AppQuot']) {
                    $exist_relChaufApp->AppQuot = $relChaufApp['AppQuot'];
                    $relChaufAppModified = true;
                }

                if ($relChaufAppModified) {
                    $relChaufApps_to_update[] = $exist_relChaufApp;
                    if ($exist_relChaufApp->client_id == null) {
                        $client_id = Client::where('Codecli', $relChaufApp['Codecli'])->first();
                        $exist_relChaufApp->client()->associate($client_id);
                        $exist_relChaufApp->save();
                    } else {
                        $exist_relChaufApp->save();
                    }
                } else {
                    $relChaufApps_already_updated[] = $exist_relChaufApp;
                }
            }
        }

        // insert relChaufApps

        //        foreach ($relChaufApps_to_insert as $relChaufApp_to_insert) {
        //            $relChaufApp_to_insert->save();
        //        }

        // update relChaufApps

        //        foreach ($relChaufApps_to_update as $relChaufApp_to_update) {
        //            $relChaufApp_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelChaufApp',
                'itemInsert' => count($relChaufApps_to_insert),
                'itemUpdate' => count($relChaufApps_to_update),
                'itemUnchanged' => count($relChaufApps_already_updated),
                'itemTotal' => count($relChaufApps_to_insert) + count($relChaufApps_to_update) + count($relChaufApps_already_updated),
            ]
        );
    }

    public function popRelEauApp()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        $querySQL1 = 'SELECT TOP 100000000 *  FROM  "RelEauApp"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relEauApps = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relEauApp

        $relEauApps_to_insert = [];
        $relEauApps_to_update = [];
        $relEauApps_already_updated = [];

        foreach ($relEauApps as $relEauApp) {
            // check if relEauApp exist
            $exist_relEauApp = RelEauApp::where([
                ['Codecli', '=', $relEauApp['Codecli']],
                ['RefAppTR', '=', $relEauApp['RefAppTR']],
                ['DatRel', '=', $relEauApp['DatRel']],
            ])->first();

            if (! $exist_relEauApp) {
                $relEauApp_new = new RelEauApp();
                $relEauApp_new->Codecli = $relEauApp['Codecli'];
                $relEauApp_new->RefAppTR = $relEauApp['RefAppTR'];
                $relEauApp_new->DatRel = $relEauApp['DatRel'];
                $relEauApp_new->FraisDiv = $relEauApp['FraisDiv'];
                $relEauApp_new->Rem1 = $relEauApp['Rem1'];
                $relEauApp_new->Rem2 = $relEauApp['Rem2'];
                $relEauApp_new->PctFraisAnn = $relEauApp['PctFraisAnn'];
                $relEauApp_new->NbCptFroid = $relEauApp['NbCptFroid'];
                $relEauApp_new->NbCptChaud = $relEauApp['NbCptChaud'];
                $relEauApp_new->RmqOcc = $relEauApp['RmqOcc'];
                $relEauApp_new->NbFraisTR = $relEauApp['NbFraisTR'];

                $client_id = Client::where('Codecli', $relEauApp['Codecli'])->first();

                $relEauApps_to_insert[] = $relEauApp_new;
                if ($client_id) {
                    $relEauApp_new->client()->associate($client_id);
                }
                $relEauApp_new->save();
            } else {
                $relEauAppModified = false;
                // update existing relEauApp

                if ($exist_relEauApp->FraisDiv != $relEauApp['FraisDiv']) {
                    $exist_relEauApp->FraisDiv = $relEauApp['FraisDiv'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->Rem1 != $relEauApp['Rem1']) {
                    $exist_relEauApp->Rem1 = $relEauApp['Rem1'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->Rem2 != $relEauApp['Rem2']) {
                    $exist_relEauApp->Rem2 = $relEauApp['Rem2'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->PctFraisAnn != $relEauApp['PctFraisAnn']) {
                    $exist_relEauApp->PctFraisAnn = $relEauApp['PctFraisAnn'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->NbCptFroid != $relEauApp['NbCptFroid']) {
                    $exist_relEauApp->NbCptFroid = $relEauApp['NbCptFroid'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->NbCptChaud != $relEauApp['NbCptChaud']) {
                    $exist_relEauApp->NbCptChaud = $relEauApp['NbCptChaud'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->RmqOcc != $relEauApp['RmqOcc']) {
                    $exist_relEauApp->RmqOcc = $relEauApp['RmqOcc'];
                    $relEauAppModified = true;
                }

                if ($exist_relEauApp->NbFraisTR != $relEauApp['NbFraisTR']) {
                    $exist_relEauApp->NbFraisTR = $relEauApp['NbFraisTR'];
                    $relEauAppModified = true;
                }

                if ($relEauAppModified) {
                    $relEauApps_to_update[] = $exist_relEauApp;
                    if ($exist_relEauApp->client_id == null) {
                        $client_id = Client::where('Codecli', $relEauApp['Codecli'])->first();
                        $exist_relEauApp->client()->associate($client_id);
                        $exist_relEauApp->save();
                    } else {
                        $exist_relEauApp->save();
                    }
                } else {
                    $relEauApps_already_updated[] = $exist_relEauApp;
                }
            }
        }

        // insert relEauApps

        //        foreach ($relEauApps_to_insert as $relEauApp_to_insert) {
        //            $relEauApp_to_insert->save();
        //        }

        // update relEauApps

        //        foreach ($relEauApps_to_update as $relEauApp_to_update) {
        //            $relEauApp_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelEauApp',
                'itemInsert' => count($relEauApps_to_insert),
                'itemUpdate' => count($relEauApps_to_update),
                'itemUnchanged' => count($relEauApps_already_updated),
                'itemTotal' => count($relEauApps_to_insert) + count($relEauApps_to_update) + count($relEauApps_already_updated),
            ]);
    }

    public function popRelChauf()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(6000);

        $querySQL1 = 'SELECT TOP 100000000 *  FROM  "RelChauf"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relChaufs = $prep->fetchAll(PDO::FETCH_ASSOC);

        //        dd($relChaufs);
        // Populate relChauf

        $relChaufs_to_insert = [];
        $relChaufs_to_update = [];
        $relChaufs_already_updated = [];

        foreach ($relChaufs as $relChauf) {
            // check if relChauf exist
            $exist_relChauf = RelChauf::where([
                ['Codecli', '=', $relChauf['Codecli']],
                ['RefAppTR', '=', $relChauf['RefAppTR']],
                ['DatRel', '=', $relChauf['DatRel']],
                ['NumRad', '=', $relChauf['NumRad']],
            ])->first();

            if (! $exist_relChauf) {
                $relChauf_new = new RelChauf();
                $relChauf_new->Codecli = $relChauf['Codecli'];
                $relChauf_new->RefAppTR = $relChauf['RefAppTR'];
                $relChauf_new->DatRel = $relChauf['DatRel'];
                $relChauf_new->NumRad = $relChauf['NumRad'];
                $relChauf_new->NumCal = $relChauf['NumCal'];
                $relChauf_new->AncIdx = $relChauf['AncIdx'];
                $relChauf_new->NvIdx = $relChauf['NvIdx'];
                $relChauf_new->Coef = $relChauf['Coef'];
                $relChauf_new->Sit = $relChauf['Sit'];
                $relChauf_new->NvIdx2 = $relChauf['NvIdx2'];
                $relChauf_new->TypCal = $relChauf['TypCal'];
                $relChauf_new->Statut = $relChauf['Statut'];
                $relChauf_new->NumImp = $relChauf['NumImp'];
                $relChauf_new->DatImp = $relChauf['DatImp'];
                $relChauf_new->hh_imp = $relChauf['hh-imp'];
                $relChauf_new->mm_imp = $relChauf['mm-imp'];
                $relChauf_new->Ok_Site = $relChauf['Ok-Site'];

                $client_id = Client::where('Codecli', $relChauf['Codecli'])->first();

                $relChaufs_to_insert[] = $relChauf_new;

                if ($client_id) {
                    $relChauf_new->client()->associate($client_id);
                    $relChauf_new->save();
                } else {
                    $relChauf_new->save();
                }
            } else {
                $relChaufModified = false;
                // update existing relChauf

                if ($exist_relChauf->NumCal != $relChauf['NumCal']) {
                    $exist_relChauf->NumCal = $relChauf['NumCal'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->AncIdx != $relChauf['AncIdx']) {
                    $exist_relChauf->AncIdx = $relChauf['AncIdx'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->NvIdx != $relChauf['NvIdx']) {
                    $exist_relChauf->NvIdx = $relChauf['NvIdx'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->Coef != $relChauf['Coef']) {
                    $exist_relChauf->Coef = $relChauf['Coef'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->Sit != $relChauf['Sit']) {
                    $exist_relChauf->Sit = $relChauf['Sit'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->NvIdx2 != $relChauf['NvIdx2']) {
                    $exist_relChauf->NvIdx2 = $relChauf['NvIdx2'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->TypCal != $relChauf['TypCal']) {
                    $exist_relChauf->TypCal = $relChauf['TypCal'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->Statut != $relChauf['Statut']) {
                    $exist_relChauf->Statut = $relChauf['Statut'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->NumImp != $relChauf['NumImp']) {
                    $exist_relChauf->NumImp = $relChauf['NumImp'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->DatImp != $relChauf['DatImp']) {
                    $exist_relChauf->DatImp = $relChauf['DatImp'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->hh_imp != $relChauf['hh-imp']) {
                    $exist_relChauf->hh_imp = $relChauf['hh-imp'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->mm_imp != $relChauf['mm-imp']) {
                    $exist_relChauf->mm_imp = $relChauf['mm-imp'];
                    $relChaufModified = true;
                }

                if ($exist_relChauf->Ok_Site != $relChauf['Ok-Site']) {
                    $exist_relChauf->Ok_Site = $relChauf['Ok-Site'];
                    $relChaufModified = true;
                }

                if ($relChaufModified) {
                    $relChaufs_to_update[] = $exist_relChauf;
                    if ($exist_relChauf->client_id == null) {
                        $client_id = Client::where('Codecli', $relChauf['Codecli'])->first();
                        $exist_relChauf->client()->associate($client_id);
                        $exist_relChauf->save();
                    } else {
                        $exist_relChauf->save();
                    }
                } else {
                    $relChaufs_already_updated[] = $exist_relChauf;
                }
            }
        }

        // insert relChaufs

        //        foreach ($relChaufs_to_insert as $relChauf_to_insert) {
        //            $relChauf_to_insert->save();
        //        }

        // update relChaufs

        //        foreach ($relChaufs_to_update as $relChauf_to_update) {
        //            $relChauf_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelChauf',
                'itemInsert' => count($relChaufs_to_insert),
                'itemUpdate' => count($relChaufs_to_update),
                'itemUnchanged' => count($relChaufs_already_updated),
                'itemTotal' => count($relChaufs_to_insert) + count($relChaufs_to_update) + count($relChaufs_already_updated),
            ]);
    }

    public function popRelEauC()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        $querySQL1 = 'SELECT TOP 10000000 *  FROM  "RelEauC"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relEauCs = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relEauC

        $relEauCs_to_insert = [];
        $relEauCs_to_update = [];
        $relEauCs_already_updated = [];

        foreach ($relEauCs as $relEauC) {
            // check if relEauC exist
            $exist_relEauC = RelEauC::where([
                ['Codecli', '=', $relEauC['Codecli']],
                ['RefAppTR', '=', $relEauC['RefAppTR']],
                ['DatRel', '=', $relEauC['DatRel']],
                ['NumCpt', '=', $relEauC['NumCpt']],
            ])->first();

            if (! $exist_relEauC) {
                $relEauC_new = new RelEauC();
                $relEauC_new->Codecli = $relEauC['Codecli'];
                $relEauC_new->RefAppTR = $relEauC['RefAppTR'];
                $relEauC_new->DatRel = $relEauC['DatRel'];
                $relEauC_new->NumCpt = $relEauC['NumCpt'];
                $relEauC_new->NoCpt = $relEauC['NoCpt'];
                $relEauC_new->AncIdx = $relEauC['AncIdx'];
                $relEauC_new->NvIdx = $relEauC['NvIdx'];
                $relEauC_new->Sit = $relEauC['Sit'];
                $relEauC_new->NvIdx2 = $relEauC['NvIdx2'];
                $relEauC_new->TypCal = $relEauC['TypCal'];
                $relEauC_new->Statut = $relEauC['Statut'];
                $relEauC_new->Envers = $relEauC['Envers'];
                $relEauC_new->NumImp = $relEauC['NumImp'];
                $relEauC_new->DatImp = $relEauC['DatImp'];
                $relEauC_new->hh_imp = $relEauC['hh-imp'];
                $relEauC_new->mm_imp = $relEauC['mm-imp'];
                $relEauC_new->Ok_Site = $relEauC['Ok-Site'];

                $client_id = Client::where('Codecli', $relEauC['Codecli'])->first();

                $relEauCs_to_insert[] = $relEauC_new;

                if ($client_id) {
                    $relEauC_new->client()->associate($client_id);
                    $relEauC_new->save();
                } else {
                    $relEauC_new->save();
                }
            } else {
                $relEauCModified = false;
                // update existing relEauC

                if ($exist_relEauC->NoCpt != $relEauC['NoCpt']) {
                    $exist_relEauC->NoCpt = $relEauC['NoCpt'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->AncIdx != $relEauC['AncIdx']) {
                    $exist_relEauC->AncIdx = $relEauC['AncIdx'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->NvIdx != $relEauC['NvIdx']) {
                    $exist_relEauC->NvIdx = $relEauC['NvIdx'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->Sit != $relEauC['Sit']) {
                    $exist_relEauC->Sit = $relEauC['Sit'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->NvIdx2 != $relEauC['NvIdx2']) {
                    $exist_relEauC->NvIdx2 = $relEauC['NvIdx2'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->TypCal != $relEauC['TypCal']) {
                    $exist_relEauC->TypCal = $relEauC['TypCal'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->Statut != $relEauC['Statut']) {
                    $exist_relEauC->Statut = $relEauC['Statut'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->Envers != $relEauC['Envers']) {
                    $exist_relEauC->Envers = $relEauC['Envers'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->NumImp != $relEauC['NumImp']) {
                    $exist_relEauC->NumImp = $relEauC['NumImp'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->DatImp != $relEauC['DatImp']) {
                    $exist_relEauC->DatImp = $relEauC['DatImp'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->hh_imp != $relEauC['hh-imp']) {
                    $exist_relEauC->hh_imp = $relEauC['hh-imp'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->mm_imp != $relEauC['mm-imp']) {
                    $exist_relEauC->mm_imp = $relEauC['mm-imp'];
                    $relEauCModified = true;
                }

                if ($exist_relEauC->Ok_Site != $relEauC['Ok-Site']) {
                    $exist_relEauC->Ok_Site = $relEauC['Ok-Site'];
                    $relEauCModified = true;
                }

                if ($relEauCModified) {
                    $relEauCs_to_update[] = $exist_relEauC;
                    if ($exist_relEauC->client_id == null) {
                        $client_id = Client::where('Codecli', $relEauC['Codecli'])->first();
                        $exist_relEauC->client()->associate($client_id);
                        $exist_relEauC->save();
                    } else {
                        $exist_relEauC->save();
                    }
                } else {
                    $relEauCs_already_updated[] = $exist_relEauC;
                }

            }
        }

        // insert relEauCs

        //        foreach ($relEauCs_to_insert as $relEauC_to_insert) {
        //            $relEauC_to_insert->save();
        //        }

        // update relEauCs

        //        foreach ($relEauCs_to_update as $relEauC_to_update) {
        //            $relEauC_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelEauC',
                'itemInsert' => count($relEauCs_to_insert),
                'itemUpdate' => count($relEauCs_to_update),
                'itemUnchanged' => count($relEauCs_already_updated),
                'itemTotal' => count($relEauCs_to_insert) + count($relEauCs_to_update) + count($relEauCs_already_updated),
            ]);

    }

    //Table: RelEauF
    //Codecli	int	 nullable
    //RefAppTR	int	 nullable
    //DatRel	varchar(50)	 nullable
    //NumCpt	decimal(18, 0)	 nullable
    //NoCpt	varchar(20)	 nullable
    //AncIdx	decimal(18, 2)	 nullable
    //NvIdx	decimal(18, 0)	 nullable
    //Sit	varchar(23)	 nullable
    //NvIdx2	decimal(18, 0)	 nullable
    //TypCal	varchar(20)	 nullable
    //Statut	varchar(16)	 nullable
    //Envers	tinyint	 nullable
    //NumImp	int	 nullable
    //DatImp	varchar(50)	 nullable
    //[hh-imp]	int	 nullable
    //[mm-imp]	int	 nullable
    //[Ok-Site]	tinyint	 nullable

    public function popRelEauF()
    {
        // Maximum execution time of 60 seconds exceeded, save current value of max_execution_time and set to 300
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(600);

        $querySQL1 = 'SELECT TOP 10000000 *  FROM  "RelEauF"'; // 100000000
        $prep = $this->conn->prepare($querySQL1);
        $prep->execute();
        $relEauFs = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Populate relEauF

        $relEauFs_to_insert = [];
        $relEauFs_to_update = [];
        $relEauFs_already_updated = [];

        foreach ($relEauFs as $relEauF) {
            // check if relEauF exist
            $exist_relEauF = RelEauF::where([
                ['Codecli', '=', $relEauF['Codecli']],
                ['RefAppTR', '=', $relEauF['RefAppTR']],
                ['DatRel', '=', $relEauF['DatRel']],
                ['NumCpt', '=', $relEauF['NumCpt']],
            ])->first();

            if (! $exist_relEauF) {
                $relEauF_new = new RelEauF();
                $relEauF_new->Codecli = $relEauF['Codecli'];
                $relEauF_new->RefAppTR = $relEauF['RefAppTR'];
                $relEauF_new->DatRel = $relEauF['DatRel'];
                $relEauF_new->NumCpt = $relEauF['NumCpt'];
                $relEauF_new->NoCpt = $relEauF['NoCpt'];
                $relEauF_new->AncIdx = $relEauF['AncIdx'];
                $relEauF_new->NvIdx = $relEauF['NvIdx'];
                $relEauF_new->Sit = $relEauF['Sit'];
                $relEauF_new->NvIdx2 = $relEauF['NvIdx2'];
                $relEauF_new->TypCal = $relEauF['TypCal'];
                $relEauF_new->Statut = $relEauF['Statut'];
                $relEauF_new->Envers = $relEauF['Envers'];
                $relEauF_new->NumImp = $relEauF['NumImp'];
                $relEauF_new->DatImp = $relEauF['DatImp'];
                $relEauF_new->hh_imp = $relEauF['hh-imp'];
                $relEauF_new->mm_imp = $relEauF['mm-imp'];
                $relEauF_new->Ok_Site = $relEauF['Ok-Site'];

                $client_id = Client::where('Codecli', $relEauF['Codecli'])->first();

                $relEauFs_to_insert[] = $relEauF_new;

                if ($client_id) {
                    $relEauF_new->client()->associate($client_id);
                    $relEauF_new->save();
                } else {
                    $relEauF_new->save();
                }
            } else {
                $relEauFModified = false;
                // update existing relEauF

                if ($exist_relEauF->NoCpt != $relEauF['NoCpt']) {
                    $exist_relEauF->NoCpt = $relEauF['NoCpt'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->AncIdx != $relEauF['AncIdx']) {
                    $exist_relEauF->AncIdx = $relEauF['AncIdx'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->NvIdx != $relEauF['NvIdx']) {
                    $exist_relEauF->NvIdx = $relEauF['NvIdx'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->Sit != $relEauF['Sit']) {
                    $exist_relEauF->Sit = $relEauF['Sit'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->NvIdx2 != $relEauF['NvIdx2']) {
                    $exist_relEauF->NvIdx2 = $relEauF['NvIdx2'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->TypCal != $relEauF['TypCal']) {
                    $exist_relEauF->TypCal = $relEauF['TypCal'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->Statut != $relEauF['Statut']) {
                    $exist_relEauF->Statut = $relEauF['Statut'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->Envers != $relEauF['Envers']) {
                    $exist_relEauF->Envers = $relEauF['Envers'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->NumImp != $relEauF['NumImp']) {
                    $exist_relEauF->NumImp = $relEauF['NumImp'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->DatImp != $relEauF['DatImp']) {
                    $exist_relEauF->DatImp = $relEauF['DatImp'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->hh_imp != $relEauF['hh-imp']) {
                    $exist_relEauF->hh_imp = $relEauF['hh-imp'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->mm_imp != $relEauF['mm-imp']) {
                    $exist_relEauF->mm_imp = $relEauF['mm-imp'];
                    $relEauFModified = true;
                }

                if ($exist_relEauF->Ok_Site != $relEauF['Ok-Site']) {
                    $exist_relEauF->Ok_Site = $relEauF['Ok-Site'];
                    $relEauFModified = true;
                }

                if ($relEauFModified) {
                    $relEauFs_to_update[] = $exist_relEauF;
                    if ($exist_relEauF->client_id == null) {
                        $client_id = Client::where('Codecli', $relEauF['Codecli'])->first();
                        $exist_relEauF->client()->associate($client_id);
                        $exist_relEauF->save();
                    } else {
                        $exist_relEauF->save();
                    }
                } else {
                    $relEauFs_already_updated[] = $exist_relEauF;
                }
            }
        }

        // insert relEauFs

        //        foreach ($relEauFs_to_insert as $relEauF_to_insert) {
        //            $relEauF_to_insert->save();
        //        }

        // update relEauFs

        //        foreach ($relEauFs_to_update as $relEauF_to_update) {
        //            $relEauF_to_update->save();
        //        }

        // restore max_execution_time
        set_time_limit($max_execution_time);

        return view('admin.sync.syncdata',
            [
                'dataName' => 'RelEauF',
                'itemInsert' => count($relEauFs_to_insert),
                'itemUpdate' => count($relEauFs_to_update),
                'itemUnchanged' => count($relEauFs_already_updated),
                'itemTotal' => count($relEauFs_to_insert) + count($relEauFs_to_update) + count($relEauFs_already_updated),
            ]);

    }
}
