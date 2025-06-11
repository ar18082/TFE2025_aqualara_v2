<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvisPassageText;
use App\Models\Models;
use App\Models\TypeEvent;
use Illuminate\Http\Request;
use Tests\Fixtures\Model;

class AvisPassageTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avisPassageTexts = AvisPassageText::all();

        return view('admin.AvisPassageText.index', compact('avisPassageTexts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeEvents = TypeEvent::all();
        $avisPassageText = new AvisPassageText();
        return view('admin.AvisPassageText.form', [
            'avisPassageText' => $avisPassageText,
            'typeEvents' => $typeEvents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $datas = $request->all();



        $avisPassageText = new AvisPassageText();
        $avisPassageText->typRlv = $datas['typRlv'];
        $avisPassageText->typePassage = $datas['typePassage'];
        $avisPassageText->acces = $datas['acces'];
        $avisPassageText->presence = $datas['presence'];
        $avisPassageText->coupure = $datas['coupure'];
        $avisPassageText->type_event_id =  $datas['typeEvent'];

        $avisPassageText->save();
        $message = __('Le contenu a été créé avec succès.');

        return redirect()->route('admin.avisPassageText.index')->with('success', $message);

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
        $typeEvents = TypeEvent::all();
        $avisPassageText = AvisPassageText::find($id);

        return view('admin.AvisPassageText.form', [
            'avisPassageText' => $avisPassageText,
            'typeEvents' => $typeEvents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $datas = $request->all();



        $avisPassageText = AvisPassageText::find($id);
        $avisPassageText->typRlv = $datas['typRlv'];
        $avisPassageText->typePassage = $datas['typePassage'];
        $avisPassageText->acces = $datas['acces'];
        $avisPassageText->presence = $datas['presence'];
        $avisPassageText->coupure = $datas['coupure'];
        $avisPassageText->type_event_id =  $datas['typeEvent'];

        $avisPassageText->save();


        $message = __('Le contenu a été modifié avec succès.');

        return redirect()->route('admin.avisPassageText.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvisPassageText $avisPassageText)
    {
        $avisPassageText->delete();

        $message = __('Le contenu a été supprimé avec succès.');

        return to_route('admin.avisPassageText.index')->with('success', $message);
    }
}
