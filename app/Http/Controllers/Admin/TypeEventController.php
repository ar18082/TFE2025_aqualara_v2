<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeEvent;
use Illuminate\Http\Request;

class TypeEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeEvents = TypeEvent::orderBy('name')->paginate(25);

        return view('admin.typeEvent.index', [
            'typeEvents' => $typeEvents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeEvent = new TypeEvent();
        return view('admin.typeEvent.form', [
            'typeEvent' => $typeEvent,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'abreviation'=>'required'
        ]);
        $name = $request->name;
        $abreviation = $request->abreviation;

        $typeEvent = new TypeEvent();
        $typeEvent->name = $name;
        $typeEvent->abreviation = $abreviation;


        $typeEvent->save();


        $message = __('Le Type d\'intervention :nom a été créé avec succès.', [
            'nom' => $name,
        ]);

        return redirect()->route('admin.typeEvent.index')->with('success', $message);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeEvent $typeEvent)
    {
        return view('admin.typeEvent.form', [
            'typeEvent' => $typeEvent,


        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeEvent $typeEvent)
    {
        $nom = $request->input('name');
        $abreviation = $request->input('abreviation');



        $typeEvent-> name = $nom;
        $typeEvent-> abreviation = $abreviation;


        $typeEvent->save();



        $message = __('Le type d\'abreviation :nom a été modifié avec succès.', [
            'nom' => $nom,
        ]);
        return to_route('admin.typeEvent.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeEvent $typeEvent)
    {
        $typeEvent->delete();

        $message = __('Le type d\'intervention :nom  a été supprimé avec succès.', [
            'nom' => $typeEvent->name,

        ]);

        return to_route('admin.typeEvent.index')->with('success', $message);
    }
}
