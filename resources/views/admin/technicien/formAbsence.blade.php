@extends('admin.base')

@section('title', 'Absence Technicien')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h1>@yield('title')</h1>
            <a href="{{ route('admin.technicien.index') }}" class="btn btn-secondary">Retour</a>
        </div>
        <form action="{{route('admin.storeAbsenceTechnicien') }}" method="POST" class="mt-5">
            @csrf
            <div class="row">
                <div class="col-12 mb-3 row ">
                    <h5>Technicien</h5>
                    <div class="col-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ $technicien->nom }}" readonly>
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $technicien->prenom }}" readonly>
                        <label for="registre_national" class="form-label">n° registre national</label>
                        <input type="text" class="form-control" id="registre_national" name="registre_national" value="{{ $technicien->registre_national }}" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $technicien->phone }}" readonly>
                        <label for="rue" class="form-label">Rue</label>
                        <input type="text" class="form-control" id="rue" name="rue" value="{{ $technicien->rue }}" readonly>
                        <label for="numero" class="form-label">n°</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="{{ $technicien->numero }}" readonly>
                    </div>
                </div>
                <div class="col-12 mb-3 row ">
                    <h5>Absence</h5>
                    <div class="col-6 mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut') }}">
                        <label for ="date_fin" class="form-label">Date de fin</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin') }}">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="motif" class="form-label">Motif</label>
                        <select class="form-control" id="motif" name="motif">
                            <option value="13">Maladie</option>
                            <option value="12">Congé</option>
                            <option value="14">Autre</option>
                        </select>
                    </div>

                </div>
                <input type="hidden" name="technicien_id" value="{{ $technicien->id }}">
                <div class=" col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-25">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

