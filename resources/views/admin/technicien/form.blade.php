@extends('admin.base')

@section('title', $technicien->exists ? 'Modifier le technicien' : 'Ajouter un technicien')

@section('content')

    <div class="container ">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <a href="{{ route('admin.technicien.index') }}" class="btn btn-secondary">Retour</a>
        </div>
        <form action="{{ $technicien->exists ? route('admin.technicien.update', $technicien->id) : route('admin.technicien.store') }}"
              method="POST" class="mt-5">
            @csrf
            @if($technicien->exists)
                @method("PUT")
            @endif
            <div class="row">
                <div class="col-12 mb-3 row ">
                    <div class="col-6 mb-3">
                        @include('shared.input', ['label' => 'Nom', 'name' => 'nom', 'value' => $technicien->nom])

                        @include('shared.input', ['label' => 'Prénom', 'name' => 'prenom', 'value' => $technicien->prenom])

                        @include('shared.input', ['label' => 'Phone', 'name' => 'phone', 'value' => $technicien->phone])
                        @include('shared.input', ['label' => 'n° registre national', 'name' => 'registre_national', 'value' => $technicien->registre_national])
                        @include('shared.input', ['label' => 'Rue', 'name' => 'rue', 'value' => $technicien->rue])
                        @include('shared.input', ['label' => 'n°', 'name' => 'numero', 'value' => $technicien->numero])

                    </div>
                    <div class="col-6 mb-3">
                        <label for="couleur" class="mt-4">Couleur :</label>
                        <select name="couleur" id="couleur" class="form-select">
                            @if ($technicien->couleur_id)
                                    <option value="{{ $technicien->couleur_id }}" selected>
                                        {{ ucfirst($technicien->colorTechnicien->couleur) }}
                                    </option>

                            @endif
                            @foreach($couleursOptionsData as $couleurOption)
                                @if ($couleurOption->id != $technicien->couleur_id)
                                    <option value="{{ $couleurOption->id }}">
                                        {{ ucfirst($couleurOption->couleur) }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                        <label for="statut" class="form-label mt-4">Status</label>
                         <select class="form-select" id="status" name="status" required>
                             @if ($technicien->status_id)
                                 <option value="{{ $technicien->status_id }}" selected>
                                     {{ ucfirst($technicien->status->nom) }}
                                 </option>
                             @endif
                                 @foreach($status as $sta)
                                     @if ($technicien->status_id != $sta->id)
                                         <option value="{{ $sta->id }}">
                                             {{ ucfirst($sta->nom) }}
                                         </option>
                                     @endif
                                 @endforeach


                         </select>

                        @include('shared.input', ['label' => 'Code Postal', 'name' => 'codePostal', 'value' => $technicien->code_postal])
                        @include('shared.input', ['label' => 'Localité', 'name' => 'localite', 'value' => $technicien->localite])


                    </div>

                    <div class="col-6 ml-5">
                        <label for="regions">Régions de dépannage :</label>
                        @foreach($regionsOptions as $index =>$regionOption)
                            <div class="form-group">
                                <label for="region_{{ $regionOption->id }}">{{ $regionOption->name }} :</label>
                                <select class="form-control" name="regions[{{ $regionOption->id }}]" id="region_{{ $regionOption->id }}">
                                    <option value="">Sélectionnez la priorité</option>

                                    @for ($i = 1; $i <= count($regionsOptions); $i++)
                                        <option value="{{ $i }}" {{ isset($technicienRegions[$index]) && $technicienRegions[$index]->pivot->priorite == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        @endforeach
                    </div>


                    <div class="col-6 md-3 ">
                        <label class="form-label mt-4"> Compétences : </label>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Catégorie</th>
                                <th scope="col">Actif</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($competencesOptions as $competence)
                                <tr>
                                    <td>{{ $competence->name }}</td>
                                    <td>{{ $competence->category }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="{{ $competence->name }}{{ $competence->id }}" name="competences[{{ $competence->id }}]" value="{{ $competence->id }}" {{ isset($technicienCompetences) && in_array($competence->id, $technicienCompetences) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $competence->name }}{{ $competence->id }}"></label>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=" col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-25">
                        @if($technicien->exists)
                            Modifier
                        @else
                            Ajouter
                        @endif
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

