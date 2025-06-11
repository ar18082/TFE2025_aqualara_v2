@extends('base')
@section('title', 'Modifier un bon de route')
@section('content')
    <div style="width: 80%; margin: 1rem auto">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-4">@yield('title')</h1>
            <a href="{{$url}}" class="btn btn-secondary">Retour</a>
        </div>

        <form action="{{route('documents.updateDocument')}}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{$type}}">
            <header>
                <div class="header-container">
                    <table>
                        <thead>
                        <tr>
                            <th>
                                <h2 class="mt-5">
                                {{count($event->techniciens) > 1 ? 'Techniciens' : 'Technicien'}} :
                                </h2>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                            @foreach($event->techniciens as $eventTechniciens)
                                <tr>
                                    <td>
                                        <select class="form-select" name="techniciens">
                                            <option value="">Choisir un technicien</option>
                                            @foreach($techniciens as $technicien)
                                                <option value="{{$technicien->id}}" {{$technicien->id == $event->techniciens[0]->id ? 'selected' : ''}}>{{$technicien->prenom}} {{$technicien->nom}}</option>
                                            @endforeach
                                        </select>

                                        {{--                                    <span class="couleur-rond" style="background-color: {{ $technicien->colorTechnicien->code_hexa}}; display: inline-block; width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;"></span>--}}
                                        {{--                                    {{$technicien->prenom}}--}}
                                        {{--                                    {{$technicien->nom}}--}}
                                        {{-- les icones font awesome ne fonctionnent pas résoudre la probleme

                                         @foreach(explode(';', $technicien->pivot->role) as $role)--}}
                                        {{--                                   --}}{{--ajouter des icones --}}
                                        {{--                                   @if($role == 'etoile')--}}
                                        {{--                                        <span class="btn"><i class="fa fa-star"></i></span>--}}
                                        {{--                                   @elseif($role == 'calo')--}}
                                        {{--                                        <span class="btn"><i class="fa-solid fa-hard-drive"></i></span>--}}
                                        {{--                                   @elseif($role == 'robinet')--}}
                                        {{--                                        <span class="btn"><i class="fa-solid fa-faucet"></i></span>--}}
                                        {{--                                   @endif--}}

                                        {{--                               @endforeach--}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </header>
            <main class="mt-4">
                <div class="container row mt-5">
                    <h2 class="mt-4">Client : </h2>
                    <div class="client col-6">
                        <input type="hidden" class="form-control" id="event_id" name="event_id" value="{{$event->id}}" >
                        <div class="form-group row">

                            <div class="col-3">
                                <label for="numero_client ">N° Client :</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control col-6" id="Codecli" name="Codecli" value="{{$event->client->Codecli}}" readonly>
                            </div>
                            <div class="col-2"></div>
                        </div>

                        <div class="form-group row mt-4">

                            <div class="col-3">
                                <label for="nom_immeuble">Nom de l'immeuble :</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control col-6" id="nom" name="nom"  value=" {{$event->client->nom}}" readonly>
                            </div>
                            <div class="col-2"></div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-3">
                                <label for="adresse">Adresse :</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control col-6" id="rue" name="rue" value="{{$event->client->rue}}">
                                <input type="text" class="form-control col-6" id="codepost" name="codepost" value="{{$event->client->codepost}}">
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="proprietaire col-6">
                        <div class="form-group row mt-4">

                            <div class="col-3">
                                <label for="nom_gerant">Nom du gérant ou propriétaire : </label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="gerant" name="gerant" value="{{$event->client->gerant}}">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-3">
                                <label for="adresse_gerant">rue du gérant ou propriétaire : </label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="rueger" name="rueger" value="{{$event->client->rueger}}">
                                <input type="text" class="form-control" id="codepostger" name="codepostger" value="{{$event->client->codepostger}}">
                            </div>
                        </div>
                    </div>
                    <div class="intervention col-12 mt-4">
                        <h2 class="mt-4">Intervention : </h2>
                        <div class="row mt-4">
                            <div class="col-2 mt-1">
                                <label for="dateEvent">Date de l'intervention :</label>
                            </div>
                            <div class="col-2">
                                <input type="date" name="dateEvent" class="form-control col-2" value="{{\Carbon\Carbon::parse($event->start)->format('Y-m-d')}}">
                            </div>
                            <div class="col-1"> de  </div>
                            <div class="col-2">
                                <input type="time" class="form-control" name="startTime" value="{{\Carbon\Carbon::parse($event->start)->format('H:i')}}">
                            </div>
                            <div class="col-1"> à  </div>
                            <div class="col-2">
                                <input type="time" class="form-control" name="endTime" value="{{\Carbon\Carbon::parse($event->end)->format('H:i')}}">                               </td>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-3">
                                <label for="type_intervention">Type d'intervention :</label>
                            </div>
                            <div class="col-6">
                                <select class="form-select" id="type_intervention" name="type_intervention">
                                    {{--                                <option>Choisir un type d'intervention</option>--}}
                                    <option value="{{$event->typeEvent->id}}" selected>{{$event->typeEvent->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-3">
                                <label for="type_materiel">Type de matériel de l'immeuble ou spécifique à l'intervention :</label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control " id="type_materiel" name="type_materiel">
                            </div>
                        </div>
                    </div>
                    <div class="messages col-12 mt-4">
                        <div class="form-group mt-4">
                            <label for="Permanantes">Remarques Permanantes :</label>
                            <textarea class="form-control" id="permanantes" name="permanantes" rows="3">{{$event->client->remarque}}</textarea>
                        </div>
                        <div class="form-group mt-4">
                            <label for="specifique">Remarques spécifique :</label>
                            <textarea class="form-control" id="specifique" name="specifique" rows="3">{{$event->commentaire}}</textarea>
                        </div>
                    </div>

                </div>
                <button type="submit" id="submitFormBonRoute" class="btn btn-primary mt-4">Soumettre</button>
            </main>

        </form>
    </div>

@endsection
