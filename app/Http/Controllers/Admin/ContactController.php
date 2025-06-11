<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.contact.index', [
            'contacts' => Contact::orderBy('nom')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contact = new Contact();

        return view('admin.contact.form', [
            'contact' => $contact,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactFormRequest $request)
    {

        $contact = Contact::create($request->validated());


        $message = __('Le Contact :nom a été créé avec succès.', [
            'nom' => $contact->nom,
        ]);

        return redirect()->route('admin.contact.index')->with('success', $message);
    }


    //    /**
    //     * Display the specified resource.
    //     */
    //    public function show(string $id)
    //    {
    //        //
    //    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contact.form', [
            'contact' => $contact,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactFormRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        $contact->contactType()->associate($request->contact_type_id)->save();

        $message = __('Le contact :lastname :firstname a été modifié avec succès.', [
            'lastname' => $contact->lastname,
            'firstname' => $contact->firstname ?? '',
        ]);

        return to_route('admin.contact.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        $message = __('Le contact :lastname :firstname a été supprimé avec succès.', [
            'lastname' => $contact->lastname,
            'firstname' => $contact->firstname ?? '',
        ]);

        return to_route('admin.contact.index')->with('success', $message);
    }
}
