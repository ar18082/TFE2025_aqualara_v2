@extends('admin.base')
@section('title',   $event->exists ? 'Modifier un évenement' : 'Créer un évenement')
@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            @if($event->exists or $client)
                <a href="{{ route('immeubles.show',$client->Codecli)}}" class="btn btn-secondary">Retour</a>

            @else
                <a href="{{route('admin.event.index')}}" class="btn btn-secondary">Retour</a>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $event->exists ? route('admin.event.update', $event->id) : route('admin.event.store') }}"
                method="POST" class="mt-5">
            @csrf
            @if($event->exists)
                @method("PUT")
            @endif

            <div class="mb-3">
                    <label class="form-label" for="client_id">Nom :</label>
                @if($event->exists)
                    <select class="form-select " name="client_id" readonly>
                        <option value="{{ $event->client_id }}"  >{{$event->client->Codecli}}: {{$event->client->nom}}</option>
                    </select>
                @elseif($client)
                    <select class="form-select " name="client_id" >
                        <option value="{{ $client->id }}" >{{$client->Codecli}}: {{$client->nom}}</option>
                    </select>

                @else
                    <select class="form-select client_id" name="client_id" id="clientSelect">
                            <option value=""></option>
                    </select>

                @endif

            </div>
            <div class="mb-3 row" id="appartements">

                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="btnDropdownAppartements" data-bs-toggle="dropdown" aria-expanded="false">
                           Appartements
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnDropdownAppartements" id="dropdownAppartements" style="width: 40%;">
                            @if($client)
                                @foreach($client->appartements as $appartement)
                                    @if($event->exists and in_array($appartement->id, $event->eventAppartements->pluck('appartement_id')->toArray()))
                                        <li>
                                            <div>
                                                <input type="checkbox" name="appartement[]" checked value="{{ $appartement->id }}" id="appartement{{$appartement->id}}">
                                                <label for="appartement{{$appartement->id}}">Appartement - {{ $appartement->RefAppTR }} - {{$appartement->proprietaire != '' ? $appartement->proprietaire: $client->gerant}} </label>
                                            </div>
                                        </li>
                                    @else
                                        <li style="margin: 1rem 0 1rem 1rem;">
                                            <div >
                                                <input type="checkbox" checked name="appartement[]" value="{{ $appartement->id }}" id="appartement{{$appartement->id}}">
                                                <label for="appartement{{$appartement->id}}">Appartement - {{ $appartement->RefAppTR }} - {{$appartement->proprietaire != '' ? $appartement->proprietaire: $client->gerant}}</label>

                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>


            </div>
            <div class="mb-3">
                <label for="typeIntervention" class="form-label">Type Intervention :</label>
                <select name="typeIntervention" id="typeIntervention" class="form-select">

                    @foreach($typeEventsOptions as $typeEvent)
                        <option value="{{ $typeEvent->id }}" {{ $event->type_event_id === $typeEvent->id ? 'selected' : '' }}>
                            {{ $typeEvent->name }}
                        </option>
                    @endforeach
                </select>
                <label id="firstPlt">
                    <input class="mt-2" type="checkbox" name="firstPlt"> Premier placement
                </label>
            </div>

            <div class="mb-3">
                @include('shared.input', ['label' => 'Date début :', 'name' => 'startDate', 'type' => 'date', 'value' => isset($event->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->start)->format('Y-m-d') : ''])
            </div>
            <div class="mb-3">
                @include('shared.input', ['label' => 'Date fin:', 'name' => 'endDate', 'type' => 'date', 'value' => isset($event->start) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->start)->format('Y-m-d') : ''])
            </div>
            <div class="mb-3">
                @include('shared.input', ['label' => 'Durée (en minute) :', 'name' => 'time', 'type' => 'number', 'value' => '30'])
            </div>
            <div class="mb-3">
                <label for="selectShift" class="form-label">Choisissez le quart de travail :</label>
                <select class="form-select" id="quart" name="quart">
                    <option value="0">Choisir un quart</option>
                    <option value="allDay" {{  $event->quart == 'allDay' ? 'selected' : '' }}>Journée entière</option>
                    <option value="AM" {{$event->quart == 'AM' ? 'selected' : '' }}>Matin</option>
                    <option value="PM" {{ $event->quart == 'PM' ? 'selected' : '' }}>Après-midi</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="commentaire" class="form-label">Commentaire :</label>
                <textarea name="commentaire" id="commentaire" class="form-control">{{ $event->commentaire }}</textarea>
            </div>

            <div class="mb-3">
                <label for="techniciens" class="form-label">Assigner technicien :</label>

                <div class="form-check">
                    <div>
                       <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Techniciens</th>

                                <th scope="col" ><i class="fa-solid fa-hard-drive"></i></th>
                                <th scope="col"><i class="fa-solid fa-faucet"></i> </th>
                                <th scope="col"><i class="fa-solid fa-star"></i></th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($techniciensOptions as $technicien)
                                 <tr>
                                      <th scope="row"> <input type="checkbox" class="form-check-input" name="techniciens[]" value="{{ $technicien->id }}" id="technicien{{ $technicien->id }}" {{ in_array($technicien->id, $event->techniciens->pluck('id')->toArray()) ? 'checked' : '' }}>
                                          <label class="form-check-label" for="technicien{{ $technicien->id }}">
                                              {{ $technicien->nom }} {{ $technicien->prenom }}
                                          </label>
                                      </th>

                                      <td><input type="checkbox" class="form-check-input" name="calo[]" id="calo_{{ $technicien->id }}" value="{{$technicien->id}}"></td>

                                      <td><input type="checkbox" class="form-check-input" name="robinet[]" id="robinet_{{ $technicien->id }}" value="{{$technicien->id}}" ></td>

                                      <td><input type="checkbox" class="form-check-input" name="etoile[]" id="etoile_{{ $technicien->id }}" value="{{$technicien->id}}"></td>
                                 </tr>
                           @endforeach
                            </tbody>
                       </table>
                    </div>
                </div>
            </div>

            <button type="submit" id="submitForm" class="btn btn-primary w-25">
                @if($event->exists)
                    Modifier
                @else
                    Ajouter
                @endif
            </button>
        </form>
    </div>


@endsection
