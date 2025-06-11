<?php

namespace App\Http\Controllers;

use App\Models\MailContent;
use App\Models\TypeEvent;
use Illuminate\Http\Request;

class MailContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mailContents = MailContent::all();
        $mailContent = new MailContent();
        $typeEvents = TypeEvent::all();
        return view('emails.mailContents.index', compact('mailContents', 'typeEvents', 'mailContent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mailContent = new MailContent();
        $typeEvents = TypeEvent::all();
        return view('emails.mailContents.form', compact('mailContent', 'typeEvents'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);



        $mailContent = new MailContent();
        $mailContent->subject = $request->input('subject');
        $mailContent->content = $request->input('content');
        $mailContent->type_event_id = $request->input('type_event_id');
        $mailContent->typeRlv = $request->input('typeRlv');

        $mailContent->save();

        return redirect()->route('mailContents.index')->with('success', 'Model e-mail créé avec succès');
    }

//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//        $mailContent = MailContent::find($id);
//        return view('emails.mailContents.show', compact('mailContent'));
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mailContent = MailContent::find($id);
        $typeEvents = TypeEvent::all();
        return view('emails.mailContents.edit', compact('mailContent', 'typeEvents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);

        $mailContent = MailContent::find($id);
        $mailContent->subject = $request->input('subject');
        $mailContent->content = $request->input('content');
        $mailContent->type_event_id = $request->input('type_event_id');
        $mailContent->typeRlv = $request->input('typeRlv');
        $mailContent->save();


        return redirect()->route('mailContents.index')->with('success', 'Model e-mail modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mailContent = MailContent::find($id);
        $mailContent->delete();

        return redirect()->route('mailContents.index')->with('success', 'Model e-mail supprimé avec succès');
    }
}
