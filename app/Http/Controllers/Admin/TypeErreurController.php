<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\typeErreur;
use Illuminate\Http\Request;

class TypeErreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.appareil.typeErreur.index', [
            'typeErreurs' => typeErreur::orderBy('appareil')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeErreur = new typeErreur();
        return view('admin.appareil.typeErreur.form', [
            'typeErreur' => $typeErreur,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $nom = $request->input('nom');
        $appareil = $request->input('appareils');

        $typeErreur = new typeErreur();
        $typeErreur->nom = $nom;
        $typeErreur->appareil = $appareil;
        $typeErreur->save();



        $message = __('Le type erreur \' :nom \' a été créé avec succès.', [
            'nom' => $nom,
        ]);

        return redirect()->route('admin.typeErreur.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(typeErreur $typeErreur)
    {


        return view('admin.appareil.typeErreur.form', [
            'typeErreur' => $typeErreur,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, typeErreur $typeErreur)
    {
        $nom = $request->input('nom');
        $appareil = $request->input('appareils');

        $typeErreur->nom = $nom;
        $typeErreur->appareil = $appareil;
        $typeErreur->save();

        $message = __('Le type Erreur :nom :appareil a été modifié avec succès.', [
            'nom' => $nom,
            'appareil' => $appareil,
        ]);
        return to_route('admin.typeErreur.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(typeErreur $typeErreur)
    {
        $typeErreur->delete();

        $message = __('Le type Erreur :nom :appareil a été supprimé avec succès.', [
            'nom' => $typeErreur->nom,
            'appareil' => $typeErreur->appareil ?? '',
        ]);

        return to_route('admin.typeErreur.index')->with('success', $message);
    }
 }
