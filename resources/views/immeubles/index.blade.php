@extends('base')

@section('title', 'Immeubles - Liste')

@section('content')
<div class="immeubles-index">
    @if(isset($alertes))
    <ul class="list-group list-group-horizontal w-100 bg-primary fs-6">
        <li class="list-group-item col-12 bg-primary text-light">
            <div>
                Alertes
            </div>
        </li>
    </ul>
    @endif

    <form id="filterform">
        <div class="row mx-1 mx-md-5 mb-2 py-3 bg-primary rounded-1">
            <div class="col-md-3">
                <div class="text-light">Code immeuble - Nom</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control client_id" id="nom" name="nom"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-light">Code Postal - Localité</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control cp_localite" id="cp_localite" name="cp_localite"></select>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="text-light">Rue</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control rue" id="rue" name="rue"></select>
                </div>
            </div> --}}
            <div class="col-md-2 m-2">
                <button type="submit" style="display: block">Rechercher</button>
            </div>
        </div>
    </form>



    @php
    $bg_card_index = 0;
    @endphp
    @forelse($clients as $client)
        @if(
            (isset($client->clichaufs->get(0)->TypRlv) && $client->clichaufs->get(0)->TypRlv == 'VISU' && !isset($client->cliEaus->get(0)->TypRlv)) ||
            (isset($client->cliEaus->get(0)->TypRlv) && $client->cliEaus->get(0)->TypRlv == 'VISU' && !isset($client->clichaufs->get(0)->TypRlv)) ||
            (isset($client->clichaufs->get(0)->TypRlv) && $client->clichaufs->get(0)->TypRlv == 'VISU' && isset($client->cliEaus->get(0)->TypRlv) && $client->cliEaus->get(0)->TypRlv == 'VISU')
        )
            @php
            $bg_card_index++;
            if ($bg_card_index % 2 == 0) {
            $bg_card = 'bg-white';
            } else {
            $bg_card = 'bg-light';
            }
            @endphp


            <div class="row mx-1 mx-md-5 my-2 rounded-1 {{ $bg_card }}">
                <a href="{{ route('immeubles.appartements',$client->Codecli) }}"
                    class="text-decoration-none rounded-1 col-6 col-md-2 position-relative my-auto order-1 order-md-1 ">
                    <div type="button" class="position-relative" style="height: 100%;width: 100%;">
                        {{ str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) }}
                        <span class="ms-1 position-absolute top-0 badge rounded-pill bg-primary">{{
                            $client->appartements->count()
                            }}</span>
                    </div>

                </a>
                <a href="{{ route('immeubles.appartements',$client->Codecli) }}"
                    class="text-decoration-none rounded-1 col-6 col-md-3 my-0 my-md-auto order-3 order-md-2">

                    <span class="ms-3 ms-md-0 fw-bold">
                        {{ $client->nom}}
                    </span>
                </a>
                <a href="{{ route('immeubles.appartements',$client->Codecli) }}"
                    class="text-decoration-none rounded-1 col-6 col-md-4 my-auto order-2 order-md-3">

                    {{ $client->rue }}<br> {{ $client->codepost }} {{ $client->codePostelbs->get(0)->Localite }}
                </a>
                <a href="{{ route('immeubles.appartements',$client->Codecli) }}"
                    class="text-decoration-none rounded-1 col-6 col-md-1 my-auto order-4 order-md-4">

                    @php
                    $chauType = $client->clichaufs->get(0);
                    $eauType = $client->cliEaus->get(0);
                    if (isset($chauType->TypRlv) && $chauType->TypRlv == 'VISU') {
                    $chauIcon = 'eye';
                    // echo '<i class="fa-regular fa-eye"></i>';
                    } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'GPRS') {
                    $chauIcon = 'wifi';
                    // echo '<i class="fa-regular fa-wifi"></i>';
                    } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'RADIO') {
                    $chauIcon = 'walkie-talkie';
                    // echo '<i class="fa-regular fa-walkie-talkie"></i>';
                    } else {
                    $chauIcon = '';
                    // echo '';
                    }

                    if (isset($eauType->TypRlv) && $eauType->TypRlv == 'VISU') {
                    $eauIcon = 'eye';
                    // echo '<i class="fa-regular fa-eye"></i>';
                    } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'GPRS') {
                    $eauIcon = 'wifi';
                    // echo '<i class="fa-regular fa-wifi"></i>';
                    } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'RADIO') {
                    $eauIcon = 'walkie-talkie';
                    // echo '<i class="fa-regular fa-walkie-talkie"></i>';
                    } else {
                    // echo '';
                    $eauIcon = '';
                    }

                    @endphp

                    <div class="col-12 col-12 d-flex my-auto mb-2 mb-md-0">
                        @if( $chauIcon != '')
                        <div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i
                                class="fa-regular fa-{{ $chauIcon }} mx-auto my-auto"></i></div>
                        @endif
                        @if( $eauIcon != '')
                        <div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i
                                class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i></div>
                        @endif
                    </div>
                </a>
                <div class="rounded-1 col-8 col-md-1 my-auto order-5 order-md-5 d-none d-md-block row">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="col-2">
                        <a href="{{ route('admin.event.create') }}?client_id={{$client->id}}"
                            class="btn btn-primary m-1 text-decoration-none py-2">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </a>
                    </div>

                    @endif

                </div>
            </div>
        @endif
    @empty
        <div class="row mx-1 my-2 rounded-1 bg-light">
            <div class="col-12">
                <div class="text-center">
                    <div class="col-12 text-center py-3">
                        Aucun client
                    </div>
                </div>
            </div>
        </div>
    



    @endforelse





    <div class="row">
        <div class="col-12">
            {{ $clients->withQueryString()->links() }}
           
        </div>
    </div>
</div>
@endsection