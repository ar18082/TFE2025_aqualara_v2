<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\statusTechnicien;
use Illuminate\Http\Request;

class StatusTechnicienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.technicien.statusTechnicien.index', [
            'statusTechniciens' => statusTechnicien::orderBy('id')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $s_Technicien = new statusTechnicien();

        return view ('admin.technicien.statusTechnicien.form', [
            's_Technicien' => $s_Technicien,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $statusTechnicien = new statusTechnicien();
        $statusTechnicien->nom = $request->nom;
        $statusTechnicien->save();


        $message = __('Le Contact :nom a été créé avec succès.', [
            'nom' => $request->nom,
        ]);

        return redirect()->route('admin.statusTechnicien.index')->with('success', $message);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(statusTechnicien $statusTechnicien)
    {


        return view('admin.technicien.statusTechnicien.form', [
           "s_Technicien" => $statusTechnicien,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, statusTechnicien $statusTechnicien)
    {
        $statusTechnicien->nom = $request->input('nom');
        $statusTechnicien->save();


        $message = __('Le status technicien  \':nom \' a été modifié avec succès.', [
            'nom' => $request->input('nom'),
        ]);
        return to_route('admin.statusTechnicien.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(statusTechnicien $statusTechnicien)
    {
        $statusTechnicien->delete();
        $message = __('status technicien  \':nom \' a été supprimé avec succès.', [
            'nom' => $statusTechnicien->nom,
        ]);

        return to_route('admin.statusTechnicien.index')->with('success', $message);
    }
}
