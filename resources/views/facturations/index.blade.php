@extends('base')

@section('title', 'Facturation')


@section('content')
    <form id="formTechnicien"  >
        <div class="row">
            <div class="col-md-3">
                <div class="text-light">Technicien</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control" id="technicien" name="technicien">
                        <option value="0">Choisir un technicien</option>
                        @foreach($techniciens as $technicien)
                        <option value="{{$technicien->id}}" >{{$technicien-> nom }}  {{$technicien->prenom}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 m-4">
                <button type="submit" id="submitFormEvent" style="display: block">Tier</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 text-end">
            <button type="button" id="submitTriSelect"  class="btn btn-primary m-2">Générer</button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Vue</th>
            <th>Date</th>
            <th>CodeCli</th>
            <th>Nom Client</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Intervention</th>
            <th>Technicien</th>
            <th>Commentaire</th>
            <th class="text-end"> Facturable</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td><a href="#" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a></td>
                <td>{{ $event->start}}</td>
                <td>{{ $event->client->Codecli }}</td>
                <td>{{ $event->client->nom }}</td>
                <td>{{ $event->client->rue }}</td>
                <td>{{ $event->client->codepost }}</td>
                <td>{{ $event->typeEvent->name }}</td>
                <td>
                    @foreach($event->techniciens as $technicien)
                        {{ $technicien->nom }} {{ $technicien->prenom }}
                    @endforeach
                </td>
                <td>{{ $event->commentaire }}</td>
                <td class="text-end">
                        <input type="hidden" name="event_id" value="{{$event->id}}">

                        <button type="button" class="btn btn-primary" id="facturable-oui-{{$event->id}}"> Oui </button>
                        <button type="button" class="btn btn-primary" id="facturable-non-{{$event->id}}"> Non </button>
                        <button type="button" class="btn btn-primary" id="facturable-planifier-{{$event->id}}"> Planifier </button>
                        <input type="hidden" name="facturable-{{$event->id}}" id="facturable-{{$event->id}}" value="">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $events->links() }}

@endsection


