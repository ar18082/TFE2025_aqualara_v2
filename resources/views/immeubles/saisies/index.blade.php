@extends('base')

@section('content')
@include("shared.admin_header_immeuble")
<div class="saisie-container">

    <div class="saisie-header">
        <h3 class="saisie-title" id="title">Saisie</h3>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="btnChauff" class="nav-link {{ request()->routeIs('immeubles.saisie') ? 'active' : '' }}"
                    href="{{ route('immeubles.saisie', ['id' => $client->Codecli]) }}">Chauffage</a>
            </li>
            <li class="nav-item">
                <a id="btnEau" class="nav-link {{ request()->routeIs('immeubles.saisieEau') ? 'active' : '' }}"
                    href="{{ route('immeubles.saisieEau', ['id' => $client->Codecli]) }}">Eau</a>
            </li>
            <li class="nav-item">
                <a id="btnGaz" class="nav-link {{ request()->routeIs('immeubles.saisieGaz') ? 'active' : '' }}"
                    href="{{ route('immeubles.saisieGaz', ['id' => $client->Codecli]) }}">Gaz</a>
            </li>
            <li class="nav-item">
                <a id="btnElec" class="nav-link {{ request()->routeIs('immeubles.saisieElec') ? 'active' : '' }}"
                    href="{{ route('immeubles.saisieElec', ['id' => $client->Codecli]) }}">Electricité</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            @if(!$check)
            @include('immeubles.saisies.components.saisieHeader')
            <x-unlock-note shortcut="(" column="paramètres" />
            @include('immeubles.saisies.components.saisieParam')

            <div class="table-container">

                <x-unlock-note shortcut="§" column="saisie" />

                @include($content)
            </div>
            @else
            @include($content)
            @endif
        </div>
    </div>
</div>

<script>
    // Passer les données des paramètres au JavaScript
    @if(!$check)
    window.parametres = @json($parametres);
    @endif
</script>




</div>
@endsection