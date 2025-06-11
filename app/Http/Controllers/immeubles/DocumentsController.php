<?php

namespace App\Http\Controllers\immeubles;

use App\Http\Controllers\Controller;
use App\Helpers\AppartementHelper;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Document;
use App\Models\Appartement;
use App\Models\Event;

class DocumentsController extends Controller
{
    public function index($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $documents = Document::where('client_id', $client->id)
        ->with('event')
        ->orderBy('created_at', 'desc')
        ->get();
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['documents'] = $documents; 

        return view('immeubles.documents.index', $data);
    }
}
