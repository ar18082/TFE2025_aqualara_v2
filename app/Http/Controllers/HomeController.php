<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
       /*$user = new User([
            'name' => 'ariz',
            'email' => 'ariz@esi-informatique.com',
            'password' => bcrypt('I8VT6tCjQwXuJHTiHarB'), // Assurez-vous de crypter le mot de passe
        ]);
        $user->save();*/


        // check if get params are set with or

        // if user is logged in, redirect to immeuble index
        if (auth()->check()) {
            return redirect()->route('immeubles.index');
        }

        if ($request->has('codeimmeuble')) {
            $codeimmeuble = $request->input('codeimmeuble');
        } else {
            $codeimmeuble = '';
        }

        if ($request->has('codegerant')) {
            $codegerant = $request->input('codegerant');
        } else {
            $codegerant = '';
        }

        if ($request->has('nom')) {
            $nom = $request->input('nom');
        } else {
            $nom = '';
        }

        if ($request->has('adresse')) {
            $rue = $request->input('rue');
        } else {
            $rue = '';
        }

        if ($codeimmeuble == '' && $codegerant == '' && $nom == '' && $rue == '') {
            $clients = Client::with('gerantImms')->orderBy('Codecli', 'asc')->paginate(25);
        } else {
            $clients = Client::with('gerantImms')->orderBy('Codecli', 'asc');
            if ($codeimmeuble != '') {
                $clients = $clients->where('Codecli', 'like', '%'.$codeimmeuble.'%');
            }
            if ($codegerant != '') {
                $clients = $clients->where('Codegerant', 'like', '%'.$codegerant.'%');
            }
            if ($nom != '') {
                $clients = $clients->where('Nom', 'like', '%'.$nom.'%');
            }
            if ($rue != '') {
                $clients = $clients->where('rue', 'like', '%'.$rue.'%');
            }
            $clients = $clients->paginate(25);
        }

        return view('home.index', [
            'clients' => $clients,
        ]);
    }
}
