@extends('base')

@section('title', 'Cartographie')

@section('content')
    <div class="row">
        <div class="col-12" id="messageUpdate" style="display: none">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Mise à jour</h4>
                <p>Les données ont été mises à jour avec succès</p>
                <hr>
            </div>
        </div>

        <div id="app" class="col-10" >
            <div id="map" style="height: 800px; width: 100%;"></div>
        </div>

        <div id="container" class="col-2 ">
            <div class="date-container row" id="sidebar">
                <button id="decrement" class="col-2">◀</button>
                <input type="date" class=" col-8" id="searchDate">
                <button id="increment" class="col-2">▶</button>
            </div>

            <div class="mt-4">
                <ul class="list-group" id="ulTechniciens">
                    <li class="list-group-item">
                        <label class="techniciens">
                            <input type="checkbox" value="{{$technicien->id}}" id="{{$technicien->id}}" name="technicien_{{$technicien->id}}" class="inputTechnicien" checked >
                            {{$technicien->nom}} {{$technicien->prenom}}
                        </label>
                    </li>
                </ul>
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-primary mt-2" id="btnDate" >Chercher</button>
            </div>

        </div>
        <div class="col-12  row">
            <div class="col-12" id="contentTimeline"></div>
        </div>
    </div>

@endsection
