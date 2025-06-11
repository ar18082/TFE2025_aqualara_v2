@extends('admin.base')

@section('title', 'Modifier Client')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <a href="{{ route('immeubles.show', $client->Codecli) }}" class="btn btn-secondary">Retour</a>
        </div>

        <form action="{{route('admin.client.update') }}"
              method="POST" class="mt-5">
            @csrf
            @if($client->exists)
                @method("PUT")
                <input type="hidden" name="id" value="{{ $client->id }}">
            @endif
            <div class="row">
                <div class="col">
                    <div class="mb-3 row">
                        <div class="col-6">
                            @include('shared.input', ['label' => 'CodeCli', 'name' => 'Codecli', 'value' => $client->Codecli])
                            @include('shared.input', ['label' => 'Reftr', 'name' => 'reftr', 'value' => $client->reftr])
                            @include('shared.input', ['label' => 'Nom', 'name' => 'nom', 'value' => $client->nom])
                            @include('shared.input', ['label' => 'Rue', 'name' => 'rue', 'value' => $client->rue])
                            @include('shared.input', ['label' => 'Pays', 'name' => 'codepays', 'value' => $client->codepays])
                            @include('shared.input', ['label' => 'Code Postal', 'name' => 'codepost', 'value' => $client->codepost])
                            @include('shared.input', ['label' => 'Téléphone', 'name' => 'tel', 'value' => $client->tel])
                            @include('shared.input', ['label' => 'Email', 'name' => 'email', 'value' => $client->email])
                        </div>
                        <div class="col-6">
                            @include('shared.input', ['label' => 'Gérant', 'name' => 'gerant', 'value' => $client->gerant])
                            @include('shared.input', ['label' => 'Rue Gérant', 'name' => 'rueger', 'value' => $client->rueger])
                            @include('shared.input', ['label' => 'Pays', 'name' => 'codepaysger', 'value' => $client->codepaysger])
                            @include('shared.input', ['label' => 'Code Postal', 'name' => 'codepostger', 'value' => $client->codepostger])
                            @include('shared.input', ['label' => 'Téléphone Gérant', 'name' => 'telger', 'value' => $client->telger])
                            @include('shared.input', ['label' => 'Email Gérant', 'name' => 'emailger', 'value' => $client->email])
                            @include('shared.input', ['label' => 'Nombre d\'appartements', 'name' => 'nbAppartements', 'value' => $client->nbAppartements])
                            <div class="form-check form-switch mt-5">

                                <input class="form-check-input" type="checkbox" id="decompteUnitaire" name="decompteUnitaire" @if($client->decomteUnitaire) checked @endif>
                                <label class="form-check-label" for="decompteUnitaire">Decompte unitaire</label>
                            </div>

                        </div>
                        <div class="col-6 mt-5">
                            @include('shared.input', ['label' => 'Date relevé', 'name' => 'dernierreleve', 'value' => substr_replace($client->dernierreleve, '/', 2, 0)])

                        </div>
                        <div class="col-6 mt-5">
                            @include('shared.input', ['label' => 'Devise', 'name' => 'devise', 'value' => $client->devise])
                        </div>
                        <div class="col-6 mt-5">
                            @include('shared.textarea', ['label' => 'Remarque', 'name' => 'remarque', 'value' => $client->remarque])
                        </div>
                        <div class="col-6 mt-5">
                            <button type="submit" class="btn btn-primary w-25 m-5">
                                @if($client->exists)
                                    Modifier
                                @else
                                    Ajouter
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endsection
