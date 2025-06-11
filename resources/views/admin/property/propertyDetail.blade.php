@extends('base')

@section('title', 'Admin Appartement - ' . str_pad($appartement->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $appartement->nom)

@section('content')



    @include("shared.admin_header_immeuble")


    @include("shared.admin_header_appartement")

    <div class="mb-3">

        <div class="accordion accordion-flush" id="accordionFlushApp">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Notes/Commentaires
                    </button>
                </h2>

                <div id="flush-collapseOne" class="accordion-collapse collapse bg-primary" data-bs-parent="#accordionFlushApp">
                    <div class="accordion-body">
                        {{--                    <div class="p-3 my-3 bg-primary">--}}
                        <form class="row" action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="post">
                            @csrf
                            <input type="hidden" name="Codecli" value="{{ $client->Codecli }}">
                            <input type="hidden" name="RefAppTR" value="{{ $appartement->RefAppTR }}">
                            <input type="hidden" name="Appartement_id" value="{{ $appartement->id }}">
                            <input type="hidden" name="notesCH" value="{{ $notesCH && $notesCH->note ? $notesCH->note : '' }}">
                            <input type="hidden" name="notesEF" value="{{$notesEF && $notesEF->note ? $notesEF->note : ''}}">
                            <input type="hidden" name="notesEC" value="{{$notesEC && $notesEC->note ? $notesEC->note : ''}}">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="form-floating my-2">
                                    <textarea class="form-control" name="notesJA" placeholder="Leave a comment here" id="Textareajustificatif_{{$appartement->id}}" style="height: 100px">
                                        {{$notesJA && $notesJA->note ? $notesJA->note : '' }}
                                    </textarea>
                                    <label for="notesJA">Commentaires</label>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0 mt-0 mt-md-3 ">
                                    <button type="submit" class="btn btn-secondary">Enregistrer Notes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Pièces jointes
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushApp">
                    <div class="accordion-body bg-primary">
                        <div class="col-12 text-center">
                            @foreach($files as $file)
                                @if($file->codeCli == $client->Codecli)
                                    <img src="{{ asset('storage/img/' . $file->filename) }}" class="img-thumbnail" alt="...">

                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------------------------------tableau affichage relevé------------------------------------------------------------------------------------------>

    <div class="row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex bg-primary rounded-1 d-sm-flex d-md-flex py-2">
        <div class="col-1 col-md-1 col-sm-0">ICONE</div>
        <div class="col-2 col-md-2 col-sm-2">N° de série</div>
        <div class="col-2 col-md-2 col-sm-2">Situation</div>
        <div class="col-2 col-md-2 col-sm-2">Dernier relevé</div>
        <div class="col-2 col-md-2 col-sm-2">Dernier index</div>
        <div class="col-3 col-md-3 col-sm-2">ACTION</div>
    </div>
    {{--    'rel_Chaufs' => $rel_Chaufs,--}}
    {{--    'rel_eau_cs' => $rel_eau_cs,--}}
    {{--    'rel_eau_fs' => $rel_eau_fs,--}}

    @php
        $chauIcon = $chaufsType == 'GPRS' ? 'wifi' : 'walkie-talkie';
        $eauIcon = $eauType == 'GPRS' ? 'wifi' : 'walkie-talkie';
    @endphp

    @foreach($rel_Chaufs as $rel_Chauf)
        @if($chaufsType == 'VISU')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-warning-subtle pb-2 pb-md-0">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-warning rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;"
                         data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i
                            class="fa-regular fa-eye mx-auto my-auto"></i></div>
                </div>

                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_Chauf->NumCal }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_Chauf->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_Chauf->updated_at->format('d-m-Y') }}</div>
                <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ $rel_Chauf->NvIdx}}<br>
                    {{--                $row['NVIDX']*$row['Coef'])-($row['AncIdx']*$row['Coef']--}}
                    {{--                    {{ $rel_Chauf->NvIdx * $rel_Chauf->Coef - $rel_Chauf->AncIdx * $rel_Chauf->Coef }} --}}
                </div>
                <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">

                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "VISU_CH",$rel_Chauf->NumCal])}}" class="btn btn-primary">
                        Detail
                        </a>

                    </div>
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "VISU_CH",$rel_Chauf->NumCal])}}" class="btn btn-primary">
                            Modifier
                        </a>

                    </div>

                </div>


            </div>

        @elseif($chaufsType == 'RADIO')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-warning-subtle">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-warning rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;"
                         data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i
                            class="fa-regular fa-{{ $chauIcon }} mx-auto my-auto"></i></div>
                </div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_Chauf->Numcal }}</div>

                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_Chauf->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_Chauf->updated_at->format('d-m-Y') }}</div>
                <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">
                    {{--                    {{ $rel_Chauf->Nvidx * ($rel_Chauf->Coef == 0 ? 1 :  $rel_Chauf->Coef) }}<br>--}}
                    {{ intval($rel_Chauf->Nvidx) }}
                    {{--                $row['NVIDX']*$row['Coef'])-($row['AncIdx']*$row['Coef']--}}
                    {{--                    {{ $rel_Chauf->Nvidx * ($rel_Chauf->Coef == 0 ? 1 :  $rel_Chauf->Coef) - $rel_Chauf->AncIdx * ($rel_Chauf->Coef == 0 ? 1 :  $rel_Chauf->Coef) }}--}}
                </div>
                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                    <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "RADIO_CH",$rel_Chauf->Numcal])}}" class="btn btn-primary">
                        Detail
                    </a>

                </div>
                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                    <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "RADIO_CH",$rel_Chauf->Numcal])}}" class="btn btn-primary">
                        Modifier
                    </a>

                </div>
            </div>

        @endif
    @endforeach
    @foreach($rel_eau_cs as $rel_eau_c)
        @if ($eauType == 'VISU')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-danger-subtle pb-2 pb-md-0">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-danger rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;">
                        <i class="fa-regular fa-eye my-auto mx-auto"></i>
                    </div>
                </div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_eau_c->NumCpt }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_c->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_c->updated_at->format('d-m-Y')  }}</div>
                <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">
                    {{ intval($rel_eau_c->NvIdx) }}
                </div>
                <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">

                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR, "VISU_EAU_C",$rel_eau_c->NumCpt])}}" class="btn btn-primary">
                            Detail
                        </a>
                    </div>
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR, "VISU_EAU_C",$rel_eau_c->NumCpt])}}" class="btn btn-primary">
                            Modifier
                        </a>
                    </div>

                </div>
            </div>
        @elseif($eauType == 'RADIO' or $eauType == 'GPRS')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-danger-subtle pb-2 pb-md-0">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-danger rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;">
                        <i class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i>
                    </div>
                </div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{$rel_eau_c->numCpt}}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_c->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_c->updated_at->format('d-m-Y')  }}</div>
                <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ $rel_eau_c->NvIdx }}</div>
                <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR, "RADIO_EAU",$rel_eau_c->NumCpt])}}" class="btn btn-primary">
                            Detail
                        </a>
                    </div>
                    <div class="col-5 col-sm-3 col-md-2 order-2 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR, "RADIO_EAU",$rel_eau_c->NumCpt])}}" class="btn btn-primary">
                            Modifier
                        </a>
                    </div>
                </div>

            </div>
        @endif
    @endforeach
    @foreach($rel_eau_fs as $rel_eau_f)
        @if ($eauType == 'VISU')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-info-subtle pb-2 pb-md-0">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-info rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;"><i class="fa-regular fa-eye my-auto mx-auto"></i></div>
                </div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_eau_f->NumCpt }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_f->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_f->updated_at->format('d-m-Y')  }}</div>
                <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">
                    {{ intval($rel_eau_f->NvIdx) }}
                </div>

                <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_f->RefAppTR, "VISU_EAU_F",$rel_eau_f->NumCpt])}}" class="btn btn-primary">
                            Detail
                        </a>
                    </div>
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_f->RefAppTR, "VISU_EAU_F",$rel_eau_f->NumCpt])}}" class="btn btn-primary">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        @elseif($eauType == 'RADIO' or $eauType == 'GPRS')
            <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-info-subtle pb-2 pb-md-0">
                <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
                    <div class="bg-info rounded-circle d-flex mx-1 my-auto"
                         style="height: 25px; width: 25px;"><i
                            class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i></div>
                </div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_eau_f->NumCpt }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_f->Sit }}</div>
                <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_f->updated_at->format('d-m-Y')  }} </div>
                <div
                    class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ $rel_eau_f->NvIdx }}
                </div>

                <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">

                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_f->RefAppTR, "RADIO_EAU",$rel_eau_f->NumCpt])}}" class="btn btn-primary">
                            Detail
                        </a>
                    </div>
                    <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                        <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_eau_f->RefAppTR, "RADIO_EAU",$rel_eau_f->NumCpt])}}" class="btn btn-primary">
                            Modifier
                        </a>
                    </div>

                </div>
            </div>
        @endif
    @endforeach


    <div class="b">
        {{--    @php--}}
        {{--    var_dump($relApps);--}}

        {{--    @endphp--}}
        {{--    @foreach($relApps as $relApp)--}}
        {{--        <div>{{ $relApp }}</div>--}}
        {{--    @endforeach--}}

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection






