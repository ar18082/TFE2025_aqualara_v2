<?php

namespace App\Http\Controllers\immeubles;

use App\Http\Controllers\Controller;
use App\Helpers\AppartementHelper;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Appartement;

class FacturesController extends Controller
{
    public function index($codecli)
    {
        $client = Client::where('Codecli', $codecli)->first();
        $factures = [];
        $data = AppartementHelper::getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['factures'] = $factures; 

        return view('immeubles.factures.index', $data);
    }
}
