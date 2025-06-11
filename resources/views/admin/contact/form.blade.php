@extends('admin.base')

@section('title', $contact->exists ? 'Modifier le Contact' : 'Ajouter un Contact')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $contact->exists ? route('admin.contact.update', $contact->id) : route('admin.contact.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($contact->exists)
            @method("PUT")
        @endif
        <div class="row">
            <div class="col">
                <div class="mb-3 row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="p-g">Contact Type</label>
                            <select class="form-control" id="p-g" name="p-g">
                               <option value="P">Propriétaire</option>
                                <option value="G">Gérant</option>
                            </select>
                       </div>
                    </div>
                    <div class="col-6"></div>

                    <div class="col-6">
                        @include('shared.input', ['label' => 'titre', 'name' => 'titre', 'value' => $contact->titre])

                        @include('shared.input', ['label' => 'Nom', 'name' => 'nom', 'value' => $contact->nom])

                        @include('shared.input', ['label' => 'Téléphone', 'name' => 'tel', 'value' => $contact->tel])

                        @include('shared.input', ['label' => 'GSM', 'name' => 'gsm', 'value' => $contact->gsm])

                        @include('shared.input', ['label' => 'Email (1)', 'name' => 'email1', 'value' => $contact->email1])
                        @include('shared.input', ['label' => 'Email (2)', 'name' => 'email2', 'value' => $contact->email2])
                        @include('shared.input', ['label' => 'Email (3)', 'name' => 'email3', 'value' => $contact->email3])
                        @include('shared.input', ['label' => 'Email (4)', 'name' => 'email4', 'value' => $contact->email4])
                        @include('shared.input', ['label' => 'Email (5)', 'name' => 'email5', 'value' => $contact->email5])
                    </div>
                    <div class="col-6">

                        @include('shared.input', ['label' => 'Rue', 'name' => 'rue', 'value' => $contact->rue])

                        @include('shared.input', ['label' => 'numero', 'name' => 'boite', 'value' => $contact->boite])

                        @include('shared.input', ['label' => 'Code postal', 'name' => 'codpost', 'value' => $contact->codpost])

                        @include('shared.input', ['label' => 'Pays', 'name' => 'pays', 'value' => $contact->pays])


                    </div>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-25">
            @if($contact->exists)
                Modifier
            @else
                Ajouter
            @endif
        </button>
    </form>
@endsection
