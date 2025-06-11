<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColorTechnicien;
use Illuminate\Http\Request;

class ColorTechnicienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.technicien.colorTechnicien.index',[
            'colors' => ColorTechnicien::orderBy('id')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $color = new ColorTechnicien();

        return view('admin.technicien.colorTechnicien.form',[
            'color' => $color
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $couleur = $request->input('couleur');
        $codeHexa = $request->input('code_hexa');

        $newColor = new ColorTechnicien();
        $newColor->couleur = $couleur;
        $newColor->code_hexa = $codeHexa;
        $newColor->save();



        $message = __('La couleur :nom a été créé avec succès.', [
            'nom' => $couleur,
        ]);

        return redirect()->route('admin.couleurTechnicien.index')->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $color = ColorTechnicien::where('id', $id)->first();

        return view ('admin.technicien.colorTechnicien.form', [
            'color' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       //dd($id);
        $id  = $request->input('color_id');

        $couleur = $request->input('couleur');
        $codeHexa = $request->input('code_hexa');

        $color = ColorTechnicien::where('id', $id )->first();

        //dd($color);
        $color->couleur = $request->input('couleur');
        $color->code_hexa = $codeHexa;
        $color->save();

        $message = __('La couleur :nom a été modifié avec succès.', [
            'nom' => $couleur,
        ]);
        return to_route('admin.couleurTechnicien.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = ColorTechnicien::where('id', $id)->first();
        $color->delete();

        $message = __('La couleur :nom  a été supprimé avec succès.', [
            'nom' => $color->couleur,

        ]);

        return to_route('admin.couleurTechnicien.index')->with('success', $message);
    }
}
