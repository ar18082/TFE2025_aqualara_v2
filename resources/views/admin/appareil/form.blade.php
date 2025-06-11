@extends('admin.base')

@section('title', $appareil->exists ? 'Modifier l\'appareil' : 'Ajouter un appareil')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.appareil.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $appareil->exists ? route('admin.appareil.update', $appareil->id) : route('admin.appareil.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($appareil->exists)
            @method("PUT")
        @endif
        <div class="row">
            <div class="col">
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="codeCli" class="form-label">Code Client</label>
                        <select id="codeCli" name="codeCli" class="form-select client_id"></select>
                    </div>
                    <div class="col-6">
                        <label for="RefAppTR" class="form-label">Appartement</label>
                        <select class="form-control bg-white" id="RefAppTR" name="RefAppTR"></select>
                    </div>
                    <div class="col-6">
                        <label for="numSerie" class="form-label">Numéro de série</label>
                        <input type="number" class="form-control bg-white" id="numSerie" name="numSerie" value="{{ old('numSerie', $appareil->numSerie) }}" minlength="8" maxlength="8" pattern="\d{8}">
                    </div>
                    <div class="col-6">
                        <label for="TypeReleve" class="form-label">Type de relevé</label>
                        <select class="form-control bg-white" id="TypeReleve" name="TypeReleve">
                            <option value="VISU_CH" {{ old('TypeReleve', $appareil->TypeReleve) =="VISU_CH"? 'selected' : '' }}>VISU_CH</option>
                            <option value="RADIO_CH" {{ old('TypeReleve', $appareil->TypeReleve) == "RADIO_CH" ? 'selected' : '' }}>RADIO_CH</option>
                            <option value="VISU_EAU_C" {{ old('TypeReleve', $appareil->TypeReleve) == "VISU_EAU_C" ? 'selected' : '' }}>VISU_EAU_C</option>
                            <option value="VISU_EAU_F" {{ old('TypeReleve', $appareil->TypeReleve) == "VISU_EAU_F" ? 'selected' : '' }}>VISU_EAU_F</option>
                            <option value="RADIO_EAU" {{ old('TypeReleve', $appareil->TypeReleve) == "RADIO_EAU" ? 'selected' : '' }}>RADIO_EAU</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="coef" class="form-label">Coefficient</label>
                        <input type="number" class="form-control bg-white" id="coef" name="coef" value="{{ old('coef', $appareil->coef) }}">
                    </div>
                    <div class="col-6">
                        <label for="sit" class="form-label">Situation</label>
                        <select class="form-control bg-white" id="sit" name="sit">
                            <option value="1" {{ old('sit', $appareil->sit) == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('sit', $appareil->sit) == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('sit', $appareil->sit) == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('sit', $appareil->sit) == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('sit', $appareil->sit) == 5 ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="sit" class="form-label">Matériel</label>
                        <select class="form-control materiel" name="materiel_id"></select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-25">
            @if($appareil->exists)
                Modifier
            @else
                Ajouter
            @endif
        </button>
    </form>
@endsection
