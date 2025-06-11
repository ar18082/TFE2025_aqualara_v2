@extends('base')

@section('title', 'Calendrier')

@section('content')

    <div class="row">


{{--        @if(Auth::check() && Auth::user()->role === 'admin')--}}
{{--            <div class="col-6 text-end  mt-3">--}}
{{--                <button type="button"  id="btnBonRouteModal" class="btn btn-primary">Bon de route</button>--}}
{{--            </div>--}}
{{--            <div class="modal fade" id="BonRouteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                <div class="modal-dialog" role="document">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title" id="exampleModalLabel">Générer les bons de route</h5>--}}

{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <label for="DateDebutModal">Date de début:</label>--}}
{{--                            <input type="date" id="DateDebutModal" class="form-control" placeholder="De">--}}

{{--                            <label for="DateFinModal">Date de fin:</label>--}}
{{--                            <input type="date" id="DateFinModal" class="form-control" placeholder=" A ">--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" id="btnCloseModal" class="btn btn-secondary" >retour</button>--}}
{{--                            <button type="button" id="btnSubmitModal" class="btn btn-primary">Générer</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

@if(Auth::check() && Auth::user()->role === 'admin')
            <div class="col-12" style="margin-top: 2rem;">
{{--                <div class="dropdown">--}}
{{--                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                        Techniciens--}}
{{--                    </button>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Another action</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

                <table class="col-12">
                    <tr>
                        <td class="m-4">
                            <input type="checkbox" name="technicienCheckbox_all" checked id="technicienCheckbox_all" value="all">
                            tout selectionner
                        </td>

                    </tr>
                    <tr>
                    @foreach($techniciensOptions as $technicien)
                            <td >
                                <input type="checkbox" name="technicienCheckbox" checked id="technicienCheckbox-{{$technicien->id}}" value="{{$technicien->nom}}-{{$technicien->id}}">
                                {{$technicien->nom}} {{$technicien->prenom}}
{{--                                <div class="progress">--}}
{{--                                    <div class="progress-bar" id="progress-bar-{{$technicien->id}}" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                </div>--}}
                                <button type="button" class="btn btn-primary" id="technicienModalBtn">
                                    <i class="fa-solid fa-calendar-plus"></i>
                                </button>
                            </td>
                    @endforeach
                    </tr>
                    <tr>
                        <td class="m-4">
                            <h3 class="mt-5">Calendrier</h3>
                        </td>

                    </tr>

                    @foreach($events as $event)
                        <tr>
                            <td class="m-4">
                                <div class="external-event btn btn-primary"  id="mydraggable" data-content="{{$event}}"> Nouvel événement</div>
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>


@endif

        <div id="calendar-container" class="col-12" style="margin: 1rem auto">

            <div id="calendar"></div>

        </div>

       {{-- <div class="col-10 text-end" style="position: absolute; bottom: 23rem; right: 5rem" >
            <ul class="list-unstyled" id="external-events">
                @foreach($events as $event)
                   <li class="external-event"   data-event='{"commentaire": "{{$event->commentaire}}", "title": " {{$event->client->nom}}","inter":"{{$event->typeEvent->name}}", "typeInter":"{{$event->type_event_id}}", "codeCli":"{{$event->client->Codecli}}"}'>{{$event->client->nom}} : {{$event->typeEvent->name}} </li>


                @endforeach
            </ul>
        </div>
        --}}


        {{--Modal pour modifier une journée entière d'un technicien --}}
        <div class="modal fade" id="technicienModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="technicienModalLabel">Modifier une journée</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">

                            <label for="startDate" class="form-label">Date à modifier:</label>
                            <input type="date" class="form-control" name="startDate" id="startDate" value="" >
                        </div>
                        <div class="mb-3">

                            <label for="newDate" class="form-label"> Nouvelle date:</label>
                            <input type="date" class="form-control" name="newDate" id="newDate" value="" >
                        </div>
                        <div class="mb-3">
                            <label for="techniciens" class="form-label">Assigner technicien :</label>
                            @foreach($techniciensOptions as $technicien)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="technicien" value="{{ $technicien->id }}" id="technicien{{ $technicien->id }}">
                                    <label class="form-check-label" for="technicien{{ $technicien->id }}">
                                        {{ $technicien->nom }} {{ $technicien->prenom }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="technicienModalBtnClose" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="technicienModalBtnSave">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--Modal affichage event --}}
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Détails de l'événement</h5>

                </div>
{{--                <form action="{{route('admin.event.update', 355)}}"--}}
{{--                       class="mt-5">--}}
{{--                    @csrf--}}




                    <div class="modal-body" id="modal-body">
                       <div class="mb-3">
                           <label class="form-label" for="client_id"><b>Nom</b></label>

                           <select class="form-select " style="width: 80%" name="client_id" >
                               <option id="clientModalOption"></option>
                               @error('client_id')
                               <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                               @enderror
                           </select>
                       </div>

                        <div class="mb-3">
                            <label for="typeIntervention" class="form-label">Type Intervention :</label>
                            <select name="typeIntervention" id="typeIntervention" class="form-select">
                                @foreach($typeEventsOptions as $typeEvent)
                                    <option value="{{ $typeEvent->id }}">
                                        {{ $typeEvent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
{{--                            <label for="materiel" class="form-label">materiel :</label>--}}
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" id="btn_appareils" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                                </button>
                                <ul class="dropdown-menu" id="appareils">
                                    {{--faire boucle sur appareil --}}

                                </ul>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label  class="form-label clo-12">Appartements :</label>
                            <div class="col-12 row" id="appartements"></div>
                        </div>
                    @include('shared.input', ['label' => '', 'name' => 'eventId', 'type' => 'hidden', 'value' => ''])
                    <div class="mb-3">
                        @include('shared.input', ['label' => 'Date :', 'name' => 'startDate', 'type' => 'date', 'value' => ''])
                    </div>
                    <div class="mb-3">
                        @include('shared.input', ['label' => 'Heure début :', 'name' => 'startTime', 'type' => 'time', 'value' =>  ''])
                        @include('shared.input', ['label' => 'Heure fin :', 'name' => 'endTime', 'type' => 'time', 'value' =>  ''])
                    </div>
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire :</label>
                        <textarea name="commentaire" id="commentaire" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="techniciens" class="form-label">Assigner technicien :</label>
                        @foreach($techniciensOptions as $technicien)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="techniciens[]" value="{{ $technicien->id }}" id="technicien{{ $technicien->id }}">
                                <label class="form-check-label" for="technicien{{ $technicien->id }}">
                                    {{ $technicien->nom }} {{ $technicien->prenom }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
{{--                            <form action="" method="POST">--}}
{{--                               --}}{{--<input type="hidden" name="brClientId" value="{{$event->client->id}}">--}}
{{--                                <input type="hidden" name="brStartTime" value="{{isset($startTime) ? $startTime : ''}}">--}}
{{--                                <input type="hidden" name="brEndTime" value="{{isset($endTime) ? $endTime : ''}}">--}}

{{--                            </form>--}}
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <button type="button" data-bs-dismiss="modal"  class="btn btn-primary btnEdit">Modifier</button>
                        @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>



                </div>
{{--                </form>--}}
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@endsection
