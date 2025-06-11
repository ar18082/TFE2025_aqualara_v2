<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'commentaire',
        'start',
        'end',
        'quart',
        'print',
        'ordre',
        'facturable',
        'valide',
        'client_id',
        'type_event_id',

    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function techniciens()
    {
        return $this->belongsToMany(Technicien::class, 'event_technicien', 'event_id', 'technicien_id')->withPivot('role');
    }

    public function appartement()
    {
        return $this->hasMany(Appartement::class);
    }

    public function eventAppartements()
    {
        return $this->hasMany(EventAppartement::class);
    }

    public function typeEvent()
    {
        return $this->belongsTo(TypeEvent::class, 'type_event_id');
    }
    public function getDateAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value);
    }

    public function document()
    {
        return $this->hasMany(Document::class, 'event_id');
    }


    public function downloadPdf()
    {
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Générer le contenu HTML du PDF (vous pouvez personnaliser ceci en fonction de vos besoins)
        $html = '<h1>Note aux occupants de l\'immeuble : </h1>';
        $html .= '<p>' . $this->client->nom . '</p>';
        $html .= '<p>' . $this->client->adresse . '</p>';
        $html .= '<p>La société AQUATEL procédera au' . $this->commentaire. ' le :</p>';
        $html .= '<p>' . $this->start . '</p>';



        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Activer les options PDF (facultatif)
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Générer le nom du fichier PDF
        $fileName = 'event_' . $this->id . '.pdf';

        // Enregistrer le PDF dans le répertoire de stockage (vous pouvez personnaliser le chemin)
        $dompdf->stream($fileName);
    }

}
