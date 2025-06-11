@extends('base')

@section('title', 'admin-Immeubles - Liste')

@section('content')

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
            <div class="col-md-3">
                <div class="text-light">Rue</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control rue" id="rue" name="rue"></select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="text-light d-flex row">
                    <div class="col-12 mb-1">Type de relevé</div>
                    <div class="col-12 d-flex text-black">

                        <div class="dropdown" data-bs-theme="dark">
                            @php
                                $chauftype_icon = request()->get('chauftype');
                                switch ($chauftype_icon) {
                                    case 'none':
                                        $chauftype_icon = 'circle-xmark';
                                        break;
                                    case 'VISU':
                                        $chauftype_icon = 'eye';
                                        break;
                                    case 'RADIO':
                                        $chauftype_icon = 'walkie-talkie';
                                        break;
                                    case 'GPRS':
                                        $chauftype_icon = 'wifi';
                                        break;
                                    default:
                                        $chauftype_icon = 'fire';
                                }

                                $eautype_icon = request()->get('eautype');
                                switch ($eautype_icon) {
                                    case 'none':
                                        $eautype_icon = 'circle-xmark';
                                        break;
                                    case 'VISU':
                                        $eautype_icon = 'eye';
                                        break;
                                    case 'RADIO':
                                        $eautype_icon = 'walkie-talkie';
                                        break;
                                    case 'GPRS':
                                        $eautype_icon = 'wifi';
                                        break;
                                    default:
                                        $eautype_icon = 'droplet';
                                }
                            @endphp
                            <button class="bg-warning rounded-circle d-flex mx-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="height: 28px; width: 28px;">
                                <i class="fa-regular fa-{{ $chauftype_icon }} mx-auto my-auto text-black"></i>
                            </button>
                            {{--                                Visuel Radio GPRS Aucun--}}
                            <ul class="dropdown-menu bg-primary" id="chauftype_ul">
                                <li><a class="dropdown-item d-flex" href="#" data-input="all"><div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-fire mx-auto my-auto text-black"></i></div><span class="text-light ms-2">Tous</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="VISU"><div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-eye mx-auto my-auto text-black"></i></div><span class="text-light ms-2">Visuel</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="RADIO"><div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-walkie-talkie mx-auto my-auto text-black"></i></div><span class="text-light ms-2">Radio</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="GPRS"><div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-wifi mx-auto my-auto text-black"></i></div><span class="text-light ms-2">GPRS</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="none"><div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-circle-xmark mx-auto my-auto text-black"></i></div><span class="text-light ms-2">Aucun</span></a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="chauftype" value="{{ request()->get('chauftype') }}" id="chauftype">

                        <div class="dropdown" data-bs-theme="dark">
                            <button class="bg-info rounded-circle d-flex mx-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="height: 28px; width: 28px;">
                                <i class="fa-regular fa-{{ $eautype_icon }} my-auto mx-auto text-black"></i>
                            </button>
                            <ul class="dropdown-menu bg-primary" id="eautype_ul">
                                <li><a class="dropdown-item d-flex" href="#" data-input="all"><div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-droplet my-auto mx-auto text-black"></i></div><span class="text-light ms-2">Tous</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="VISU"><div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-eye my-auto mx-auto text-black"></i></div><span class="text-light ms-2">Visuel</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="RADIO"><div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-walkie-talkie my-auto mx-auto text-black"></i></div><span class="text-light ms-2">Radio</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="GPRS"><div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-wifi my-auto mx-auto text-black"></i></div><span class="text-light ms-2">GPRS</span></a></li>
                                <li><a class="dropdown-item d-flex" href="#" data-input="none"><div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-circle-xmark my-auto mx-auto text-black"></i></div><span class="text-light ms-2">Aucun</span></a></li>
                            </ul>
                        </div>

                        <input type="hidden" name="eautype" value="{{ request()->get('eautype') }}" id="eautype">

                    </div>

                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" style="display: block">Rechercher</button>
            </div>

        </div>
    </form>


    @php
        $bg_card_index = 0;
    @endphp
    @forelse($clients as $client)
        @php
            $bg_card_index++;
            if ($bg_card_index % 2 == 0) {
                $bg_card = 'bg-white';
            } else {
                $bg_card = 'bg-light';
            }
        @endphp
        <a href="{{ route('admin.show',$client->Codecli) }}" class="text-decoration-none" >

            <div class="row mx-1 mx-md-5 my-2 rounded-1 {{ $bg_card }}">
                <a href="{{ route('admin.show',$client->Codecli) }}" class=" text-decoration-none rounded-1 col-6 col-md-2 position-relative my-auto order-1 order-md-1">
                     <div class="">
                        <div type="button" class="position-relative" style="height: 100%;width: 100%;" >
                            {{ str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) }}
                            <span class="ms-1 position-absolute top-0 badge rounded-pill bg-primary">{{ $client->appartements->count() }}</span>
                        </div>
                    </div>
                    {{--                </a>--}}
                </a>

                <a href="{{ route('admin.show',$client->Codecli) }}" class=" text-decoration-none rounded-1 col-6 col-md-3 my-0 my-md-auto order-3 order-md-2" >
                    <span class="ms-3 ms-md-0 fw-bold" >
                        {{ $client->nom}}
                    </span>
                </a>
                <a href="{{ route('admin.show',$client->Codecli) }}" class="text-decoration-none rounded-1 col-6 col-md-4 my-auto order-2 order-md-3">
                    {{ $client->rue }}<br> {{ $client->codepost }} {{ $client->codePostelbs->get(0)->Localite }}
                </a>
                <a href="{{ route('admin.show',$client->Codecli) }}" class="text-decoration-none rounded-1 col-6 col-md-1 my-auto order-4 order-md-4">
                    @php
                        $chauType = $client->clichaufs->get(0);
                        $eauType = $client->cliEaus->get(0);
                        if (isset($chauType->TypRlv) && $chauType->TypRlv == 'VISU') {
                            $chauIcon = 'eye';
    //                        echo '<i class="fa-regular fa-eye"></i>';
                        } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'GPRS') {
                            $chauIcon = 'wifi';
    //                        echo '<i class="fa-regular fa-wifi"></i>';
                        } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'RADIO') {
                            $chauIcon = 'walkie-talkie';
    //                        echo '<i class="fa-regular fa-walkie-talkie"></i>';
                        } else {
                            $chauIcon = '';
    //                        echo '';
                        }

                        if (isset($eauType->TypRlv) && $eauType->TypRlv == 'VISU') {
                            $eauIcon = 'eye';
    //                        echo '<i class="fa-regular fa-eye"></i>';
                        } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'GPRS') {
                            $eauIcon = 'wifi';
    //                        echo '<i class="fa-regular fa-wifi"></i>';
                        } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'RADIO') {
                            $eauIcon = 'walkie-talkie';
    //                        echo '<i class="fa-regular fa-walkie-talkie"></i>';
                        } else {
    //                        echo '';
                            $eauIcon = '';
                        }

                    @endphp

                    <div class="col-12 col-12 d-flex my-auto mb-2 mb-md-0">
                        @if( $chauIcon != '')
                            <div class="bg-warning rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i class="fa-regular fa-{{ $chauIcon }} mx-auto my-auto"></i></div>
                        @endif
                        @if( $eauIcon != '')
                            <div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;"><i class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i></div>
                        @endif
                    </div>
                </a>
                <a href="{{ route('admin.event.create') }}?client_id={{$client->id}}" class="text-decoration-none btn btn-primary rounded-1 col-3 col-md-1 my-auto order-5 order-md-5 d-none d-md-block">
                    <i class="fa-solid fa-calendar-plus"></i>
                </a>
            </div>
        </a>

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
            {{-- {{ $clients->links() }}--}}
        </div>
    </div>
@endsection

