<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppartementMateriel;
use Illuminate\Http\Request;

class AppartementMaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appartementMateriels = AppartementMateriel::all();

        return view('admin.appartement_materiel.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $appartementMateriel = new AppartementMateriel();
        return view('admin.appartement_materiel.form' , compact('appartementMateriel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.appartement_materiel.index');
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
    public function edit(string $id)
    {
        return view('admin.appartement_materiel.form');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return view('admin.appartement_materiel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return view('admin.appartement_materiel.index');
    }
}
