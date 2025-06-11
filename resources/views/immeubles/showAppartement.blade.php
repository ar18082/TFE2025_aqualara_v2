@extends('base')

@section('title', 'Appartement - ' . str_pad($appartement->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $appartement->nom)

@section('content')
    @include("shared." . (Auth::check() && Auth::user()->role === 'admin' ? "admin_header_immeuble" : "header_immeuble"))
    @include("shared." . (Auth::check() && Auth::user()->role === 'admin' ? "admin_header_appartement" : "header_appartement"))
    @include('immeubles.ShowAppartement.detailAppartement')
{{--    @include('immeubles.ShowAppartement.addIndex')--}}
    @include('immeubles.ShowAppartement.notes')
    @include('immeubles.ShowAppartement.piecesJointes')
{{--    @include('immeubles.ShowAppartement.rapport')--}}

    <div id="showAppareils">
        <div class="row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex bg-primary rounded-1 d-sm-flex d-md-flex py-2">

            <div class="col-1 col-md-0 col-sm-0 ">ICONE</div>
            <div class="col-2 col-md-2 col-sm-2">N° de série</div>
            <div class="col-2 col-md-1 col-sm-2">Situation</div>
            <div class="col-2 col-md-2 col-sm-2">Dernier relevé</div>
            <div class="col-2 col-md-2 col-sm-2">Dernier index</div>
            <div class="col-3 col-md-2 col-sm-2">ACTION</div>

        </div>

        @foreach($releves as $item)
                @php
                    $btnColor = 'btn-primary';
                @endphp
                @foreach($appareilsErreurs as $appareilErreur)
                    @if($appareilErreur->appareil->numSerie == $item->NumCal)
                        @php
                         $btnColor = 'bg-danger';
                        @endphp
                    @else
                        @php
                            $btnColor = 'btn-primary';
                        @endphp
                    @endif
                @endforeach



            @switch($item->getTable())
                @case('rel_chaufs')
                        @php $bg = 'bg-warning-subtle'; $bg_icon = 'bg-warning'; $type = 'VISU_CH'; $numcpt = $item->NumCal; $index = $item->NvIdx; $icone = 'fa-eye';
                                if($chaufsType == 'RADIO'){
                                    $dismissed = true;
                                }
                        @endphp

                    @break
                @case('rel_rad_chfs')
                        @php $bg = 'bg-warning-subtle'; $bg_icon = 'bg-warning'; $type = 'RADIO_CH'; $numcpt = $item->Numcal; $index = $item->Nvidx;
                            if($chaufsType == 'VISU'){
                                $dismissed = true;
                            }elseif ($chaufsType == 'RADIO'){
                                   $icone = 'fa-walkie-talkie';
                              }elseif ($chaufsType == 'GPRS'){
                                   $icone = 'fa-wifi';
                              }
                        @endphp
                    @break
                @case('rel_eau_c_s')
                        @php $bg = 'bg-danger-subtle'; $bg_icon = 'bg-danger'; $type = 'VISU_EAU_C'; $numcpt = $item->NumCpt; $index = $item->NvIdx; $icone = 'fa-eye';
                            if($eauType == 'RADIO'){
                                $dismissed = true;
                            }
                        @endphp
                    @break
                @case('rel_eau_f_s')
                        @php $bg = 'bg-info-subtle'; $bg_icon = 'bg-info'; $type = 'VISU_EAU_F'; $numcpt = $item->NumCpt; $index = $item->NvIdx; $icone = 'fa-eye';
                            if($eauType == 'RADIO'){
                                    $dismissed = true;
                            }
                        @endphp
                    @break
                @case('rel_rad_eaus')
                        @php $bg = 'bg-info-subtle'; $bg_icon = 'bg-info'; $type = 'RADIO_EAU'; $numcpt = $item->Numcal; $index = $item->Nvidx; ;
                              if($eauType == 'VISU'){
                                    $dismissed = true;
                              }elseif ($eauType == 'RADIO'){
                                   $icone = 'fa-walkie-talkie';
                              }elseif ($eauType == 'GPRS'){
                                   $icone = 'fa-wifi';
                              }
                        @endphp
                    @break
            @endswitch
                <input type="hidden" name="appartement_RefAppTR" id="appartement_RefAppTR" value="{{$appartement->RefAppTR}}">
                <input type="hidden" name="appartement_Codecli" id="appartement_Codecli" value="{{$appartement->Codecli}}">

                <div class="row {{$bg}} mx-1 mx-md-5 mb-2 roun ded-1  pb-2 pb-md-0" >
                    <a href="{{ route('immeubles.showReleve', ['Codecli_id' => $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR, 'type' => strval($type), 'numCal' => intval($numcpt)]) }}" style="text-decoration: none" class="col-0 col-md-1  col-sm-1 my-auto order-0 order-md-0" >
                        <div class=" {{$bg_icon}} rounded-circle d-flex mx-1 my-auto " style="height: 25px; width: 25px;"
                             data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i
                                class="fa-regular {{$icone}} mx-auto my-auto"></i>
                        </div>
                    </a>

                    <a href="{{ route('immeubles.showReleve', ['Codecli_id' => $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR, 'type' => strval($type), 'numCal' => intval($numcpt)]) }}" style="text-decoration: none; color: #000" class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{$numcpt}}</a>

                    <a href="{{ route('immeubles.showReleve', ['Codecli_id' => $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR, 'type' => strval($type), 'numCal' => intval($numcpt)]) }}" style="text-decoration: none; color: #000" class="col-1 col-md-1 col-sm-2 my-auto order-2 order-md-3">{{$item->Sit}}</a>

                    <a href="{{ route('immeubles.showReleve', ['Codecli_id' => $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR, 'type' => strval($type), 'numCal' => intval($numcpt)]) }}" style="text-decoration: none; color: #000" class="col-1 col-md-2 col-sm-1 my-auto order-3 order-md-5">{{\Carbon\Carbon::parse($item->updated_at)->format('d-m-Y')}}</a>
                    <a href="{{ route('immeubles.showReleve', ['Codecli_id' => $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR, 'type' => strval($type), 'numCal' => intval($numcpt)]) }}" style="text-decoration: none; color: #000" class="col-1 col-md-2 col-sm-2 my-auto order-4 order-md-4">{{$index}}</a>
                    <div class="order-5 col-7 col-md-3 col-sm-3 row container_button_action">
                        <div class="col-4 col-sm-3 col-md-6 order-1 button_action mt-1">
                            <select name="typeErreur" class="btn {{$btnColor}} typeErreur" id="{{$type}}-{{$numcpt}}" style="width: 100%">
                                @php($selected = '')
                                @if($appareilsErreurs)
                                    <option value="Erreur" {{$selected}}>Choisir une Erreur</option>

                                @else
                                    @foreach($appareilsErreurs as $appareilErreur)
                                        @if($appareilErreur->appareil->numSerie != $numcpt)
                                            <option value="Erreur" {{$selected}}>Choisir une Erreur</option>
                                        @endif
                                    @endforeach
                                @endif

                                @foreach ($typeErreurs as $typeErreur)

                                        @foreach($appareilsErreurs as $appareilErreur)
                                            @if($appareilErreur->appareil->numSerie == $numcpt and $appareilErreur->type_erreur_id == $typeErreur->id)
                                                @php($selected = 'selected')
                                            @else
                                                @php($selected = '')
                                            @endif

                                        @endforeach
                                    @if($item->getTable() == 'rel_chaufs' or $item->getTable() == 'rel_rad_chfs')
                                        @if($typeErreur->appareil == 'calorimetre')

                                            <option value="{{ $typeErreur->id }}" {{$selected}}>

                                                {{ $typeErreur->appareil }} : {{$typeErreur->nom}}
                                            </option>
                                        @endif
                                    @else
                                        @if($typeErreur->appareil == 'compteur_eau')
                                            <option value="{{ $typeErreur->id }}" {{$selected}}>
                                                {{ $typeErreur->appareil }} : {{$typeErreur->nom}}
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @if($dismissed)
                            <div class=" bg-danger rounded-circle d-flex mx-1 my-auto  col-3 col-sm-5 col-md-3 order-2 mt-1" style="height: 25px; width: 25px;"
                                 data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                            </div>
                        @else
                            <div class="col-3 col-sm-5 col-md-3 order-2 mt-1" >
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">Notes</button>
                            </div>
                            <div class="col-3 col-sm-4 col-md-3 order-3 button_action mt-1">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>
                            </div>
                        @endif

                    </div>
                </div>

            @include('immeubles.modalAppartement')
            @include('immeubles.modalImages' , ['numSerie' => true, 'value' => $numcpt])

        @endforeach
    </div>

{{--    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection




