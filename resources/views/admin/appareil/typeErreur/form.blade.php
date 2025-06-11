@extends('admin.base')

@section('title', $typeErreur->exists ? 'Modifier Type Erreur' : 'Ajouter un Type Erreur')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.typeErreur.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $typeErreur->exists ? route('admin.typeErreur.update', $typeErreur->id) : route('admin.typeErreur.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($typeErreur ->exists)
            @method("PUT")
        @endif
        <div class="row mb-4">

                    <div class="col-6 ">
                        @include('shared.input', ['label' => 'Nom', 'name' => 'nom', 'value' => $typeErreur->nom])

                        <select name="appareils" id="type_erreur" class="form-select mt-2">
                            <option value="calorimetre">Calorimètre</option>
                            <option value="compteur_eau">Compteur Eau</option>
                            <option value="compteur_integrateur">Compteur Intégrateur</option>
                        </select>

                    </div>


                </div>
            </div>
            <button type="submit" class="btn btn-primary m-4">
                @if($typeErreur->exists)
                    Modifier
                @else
                    Ajouter
                @endif
            </button>
        </div>


    </form>
@endsection
