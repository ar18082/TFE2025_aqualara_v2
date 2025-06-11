@extends('base')

@section('title', 'Liste factures')

@section('content')
    <form id="formEvent"  >
        <div class="row">
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
            <div class="col-md-3">
                <div class="text-light">Type d'intervention</div>
                <div class="input-group input-group-sm">
                    <select type="text" class="form-control TypeInter" id="TypeInter" name="TypeInter"></select>
                </div>
            </div>
            <div class="col-md-2 m-2">
                <button type="submit" id="submitFormEvent" style="display: block">Rechercher</button>
            </div>
        </div>
    </form>
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
            <th class="text-end"> Facture</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)

            <tr>
                <td><a href="{{route('facturation.detailFacture', $event->id)}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a></td>
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
                    <button type="button" class="btn btn-primary" id="facturable-oui-{{$event->id}}"> Générer </button>
                </td>
            </tr>

        @endforeach
        </tbody>

    </table>
    {{ $events->links() }}

@endsection
