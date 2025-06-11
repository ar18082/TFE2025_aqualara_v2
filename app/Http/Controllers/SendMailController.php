<?php

namespace App\Http\Controllers;

use App\Mail\CustomMail;
use App\Models\Event;
use App\Models\MailContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
//    public function index()
//    {
//        return view('emails.form');
//    }

    public function send(Request $request)
    {

        // valider les données
        $request->validate([
            'dateDebut' => 'required|date',
        ]);

        $dateDebut = $request->dateDebut . ' 00:00:00';

        // récuperer les events compris entre les dates de début et de fin
        $query = Event::where('start', '>=', $dateDebut)
            ->with('client.cliEaus')
            ->with('client.clichaufs')
            ->with('client.codePostelbs')
            ->with('techniciens')
            ->with('typeEvent')
            ->with('document');


        if($request->dateFin != null) {
            $dateFin = $request->dateFin . ' 23:59:59';
            $query->where('end', '<=', $dateFin);
        }

        $events = $query->get();



        foreach ($events as $event) {
            $date = Carbon::parse($event->start)->locale('fr_FR')->isoFormat('dddd DD MMMM YYYY');
            $heure = '';
            switch ($event->quart){
                case 'AM':
                    $heure = ' entre 08h30 et 12h30';
                    break;
                case 'PM':
                    $heure = ' entre 13h00 et 17h30';
                    break;
                case 'AllDay':
                    $heure = ' entre 08h30 et 17h30';
                    break;
            }
            $date = $date . $heure;

            $queryMail = MailContent::where('type_event_id', $event->type_event_id);


            if($event->client->clichaufs->count() > 0  && $event->client->cliEaus->count() > 0){
                if($event->client->clichaufs->first()->TypRlv == $event->client->cliEaus->first()->TypRlv){
                    $queryMail->where('typeRlv', $event->client->clichaufs->first()->TypRlv);
                }else{
                    $queryMail->where('typeRlv', 'mixte');
                }
            }else if($event->client->clichaufs->count() > 0  && $event->client->cliEaus->count() == 0) {

                $queryMail->where('typeRlv', $event->client->clichaufs->first()->TypRlv);

            }else if($event->client->clichaufs->count() == 0  && $event->client->cliEaus->count() > 0){

                $queryMail->where('TypRlv', $event->client->cliEaus->first()->TypeRlv);
            }else {
                $queryMail->where('TypRlv', 'autre');
            }

            $queryMail->first();
            $mailContent = $queryMail->first();



            if ($mailContent) {
                $subject = $mailContent->subject;
                $content = $mailContent->content;
                $content = str_replace(['[client]', '[date]'], [$event->client->nom, $date], $content);

            } else {
                $subject = 'Default Subject';
                $content = 'Default Content';
            }


            // attacher le document qui porte le type Avis de passage
            $attachments = [];
            foreach ($event->document as $doc) {
                if ($doc->type == 'Avis de passage') {
                    $attachments[] = storage_path('app/' . $doc->link);
                }
            }


            $email = $event->client->email != null ? $event->client->email : 'planning@aquatel.be';

            // envoyer le mail
             $mail = new CustomMail($content, $subject, $attachments);

            Mail::raw($content, function ($message) use ($email, $subject, $attachments) {
                $message->to($email)
                    ->subject($subject);
                foreach ($attachments as $attachment) {
                    $message->attach($attachment);
                }
            });

        }

        return redirect()->back()->with('success', 'Mail envoyé avec succès');

    }
}
