{{--@extends('admin.base')--}}

{{--@section('title', $appareil->exists ? 'Modifier l\'appareil' : 'Ajouter un appareil')--}}

{{--@section('content')--}}

{{--    <div class="d-flex justify-content-between align-items-center">--}}
{{--        <h1>@yield('title')</h1>--}}
{{--        <a href="{{ route('admin.appareil.index') }}" class="btn btn-secondary">Retour</a>--}}
{{--    </div>--}}

{{--    <form--}}
{{--            action="{{ $appareil->exists ? route('admin.appareil.update', $appareil->id) : route('admin.appareil.store') }}"--}}
{{--            method="POST" class="mt-5">--}}
{{--        @csrf--}}
{{--        @if($appareil->exists)--}}
{{--            @method("PUT")--}}
{{--        @endif--}}
{{--        <div class="row">--}}

{{--            <div class="col-12 row m-2">--}}
{{--                <div class="col-4 text-start">--}}
{{--                    <label for="selectType"> Choisissez le materiel :</label>--}}
{{--                    <select id="materiel" name="materiel" class="form-select">--}}
{{--                        <option selected>Choisir materiel</option>--}}
{{--                        <option value="Compteur_eau">Compteur d'eau</option>--}}
{{--                        <option value="Calorimetre">Calorimetre</option>--}}
{{--                        <option value="Integrateur">Integrateur</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="col-12 row text-center mt-4" id="formMateriel_p2">--}}

{{--            </div>--}}
{{--            <div class="col-12 row text-center mt-4" id="formMateriel_p3">--}}


{{--            </div>--}}
{{--            @include('admin.materiel.composants.time', ['label' => 'Temps de lecture : ', 'name' => 'cpt_commu_timeLect', 'class' => 'mt-2', 'idDiv' => 'timeLect'])--}}
{{--            @include('admin.materiel.composants.time', ['label' => 'Temps de montage : ', 'name' => 'cpt_commu_timeMont', 'class' => 'mt-2', 'idDiv' => 'timeMont'])--}}
{{--        </div>--}}

{{--        <button type="submit" class="btn btn-primary w-25 mt-5">--}}
{{--            @if($appareil->exists)--}}
{{--                Modifier--}}
{{--            @else--}}
{{--                Ajouter--}}
{{--            @endif--}}
{{--        </button>--}}
{{--    </form>--}}
{{--@endsection--}}
