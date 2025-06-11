@extends('base')

@section('title', 'Facturation')


@section('content')
    <form action="{{route('facturation.generateFacture')}}" method="GET">
        <div class="row">
            <div class="col-md-12 row mb-3">
                <div class="col-md-8"></div>
                <div class="col-md-3 mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Client</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$event->client->nom}}">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Rue</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$event->client->rue}}">

                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">code postal</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$event->client->codePostelbs[0]['codePost']}}">

                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Localite</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$event->client->codePostelbs[0]['Localite']}}">

                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Localite</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$event->client->codePostelbs[0]['CodePays']}}">

                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                        <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Echéance</span>
                        <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ \Carbon\Carbon::parse($dateEcheance)->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
               <table>
                   <thead>
                        <tr>
                            <th>Réf.</th>
                            <th>Qté</th>
                            <th></th>
                            <th>P.Unit.</th>
                            <th>Montant</th>
                        </tr>
                   </thead>
                   <tbody>
                        <tr>
                            <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                            <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                            <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                            <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                            <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                        </tr>
                   </tbody>
               </table>
            </div>
            <div class="col-md-6 mb-3">
                <table>
                    <thead>
                    <tr>
                        <th>Base</th>
                        <th>Taux</th>
                        <th></th>
                        <th>TVA</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                        <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>
                        <td></td>
                        <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 mb-3  ">
                <table>
                    <tbody>
                    <tr>
                        <th>A payer: </th>
                        <td><input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12" >
                <button type="submit" class="btn btn-primary">Générer Facture </button>
            </div>
        </div>
    </form>
@endsection
