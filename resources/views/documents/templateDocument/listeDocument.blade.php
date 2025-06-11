@extends('base')
@section('title', $title)
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
    </div>
    <div class="m-2">
        <div>
            <form action="{{route('documents.searchDocument', $type)}}" class="row" method="GET">
                @csrf
                <div class="mb-3 col-5">
                @if($type == 'Bon')
                    <select name="technicien" class="form-control" >
                        <option value="">Selectionner un technicien</option>
                        @foreach($techniciens as $technicien)
                            <option value="{{$technicien->id}}">{{$technicien->prenom}} {{$technicien->nom}}</option>
                        @endforeach

                    </select>
                @else
                    <select  name='client_id' class='client_id form-control'></select>
                @endif
                </div>
                <div class="mb-3 col-1"></div>
                <div class="mb-3 col-5">
                    <input type="date"  name="date" class="form-control" placeholder="Date">
                </div>

                <div class="mb-3 row">
                    <button type="submit" class="btn btn-primary col-1">Chercher</button>
                </div>
            </form>
        </div>
    </div>
    <ul class="nav nav-tabs mt-3 mb-4">
        @if($type == 'Rapport')
            <li class="nav-item">
                <a href="{{route('documents.editRapport', 0)}}" class="nav-link active ">Créer Rapport</a>
            </li>
        @elseif($type == 'Avis')
            <li class="nav-item">
                <div class="dropdown col-3">
                    <button class="nav-link active dropdown-toggle" type="button" id="dropdownFormSendMail" data-bs-toggle="dropdown" aria-expanded="false">
                        Envoyer E-mail
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownFormSendMail">
                        @include('emails.form')
                    </div>
                </div>
            </li>
        @endif
    </ul>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Selectionner</th>
            <th>CodeCli</th>
            <th>Nom Client</th>
            <th>Date de l'intervention</th>
            <th>Type de l'intervention</th>
            <th>Technicien</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documents as $document)
            <tr id="{{$document->id}}">
                <td><input type="checkbox" id="checked_send-{{$document->id}}"/> </td>
                <td>{{$document->client->Codecli}}</td>
                <td>{{$document->client->nom}}</td>
                <td>{{$document->event ? \Carbon\Carbon::parse($document->event->start)->format('d-m-Y') : ''}}</td>
                <td>{{$document->event ? $document->event->typeEvent->name :''}}</td>
                <td>{{$document->event ? ($document->event->techniciens->count() > 0 ? $document->event->techniciens[0]->nom . ' ' . $document->event->techniciens[0]->prenom : 'Non defini') : 'Non defini' }}</td>
                <td>
                    <a href="{{route("documents.showDocument", $document->id)}}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{route("documents.editDocument", $document->id)}}" class="btn btn-primary">
                        <i class="fa fa-pen"></i>
                    </a>
                    <a href="{{route("documents.deleteDocument", $document->id)}}" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <script>
        function toggleCheckboxes(masterCheckbox) {

            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#checkbox_allSelected)');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = masterCheckbox.checked;
            });
        }
    </script>
    {{--<script>
        var buttons = document.querySelectorAll('[id^="btnPrint-"]');

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                var eventId = button.id.split('-').pop();
                var newWindow = window.open('/documents/printAvisDePassage/'+ eventId);
                newWindow.onload = function(){
                    newWindow.print();
                    /* var tr = document.getElementById(eventId);
                     var tds = tr.querySelectorAll('td');

                     tds.forEach(function(td) {
                         td.style.backgroundColor = 'green';
                     });*/
                }
            });
        });

    </script>
--}}
@endsection
