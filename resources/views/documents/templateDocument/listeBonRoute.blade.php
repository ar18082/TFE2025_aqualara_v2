@extends('base')
@section('title', $events ? 'Liste des bons de route' : 'Modifier un bon route')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>

    </div>

   {{--<form id="formEvent"  >
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
--}}


    <table class="table table-striped">
        <thead>
        <tr>

            <th>Date</th>
            <th>CodeCli</th>
            <th>Nom Client</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Intervention</th>
            <th>Technicien</th>
            <th>Commentaire</th>
            <th>deja imprimer</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr id="{{$event->id}}" >
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->start}}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->client->Codecli }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->client->nom }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->client->rue }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->client->codepost }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->typeEvent->name }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">
                    @foreach($event->techniciens as $technicien)
                        {{ $technicien->nom }} {{ $technicien->prenom }}
                    @endforeach
                </td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}">{{ $event->commentaire }}</td>
                <td style="{{$event->print ? 'background-color: green;' : ' '}}"><input type="checkbox" {{ $event->print ? 'checked' : '' }} id="checkbox-{{$event->id}}"></td>
                <td class="text-end" style="{{$event->print ? 'background-color: green;' : ' '}}">
                    <a href="{{route('documents.editBonRoute', $event->id)}}" class="btn btn-primary">
                        <i class="fa fa-pen"></i>
                    </a>

                    <a href="{{route('documents.downloadPdfBonDeRoute', $event->id)}}" id="btnPrint-{{$event->id}}" class="btn btn-primary">
                         <i class="fa fa-file-arrow-down"></i>
                     </a>
                   <button type="button" id="btnPrint-{{$event->id}}" class="btn btn-primary">
                         <i class="fa fa-print"></i>
                     </button>

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <script>

       var buttons = document.querySelectorAll('[id^="btnPrint-"]');
        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                var eventId = button.id.split('-').pop();
                var newWindow = window.open('/documents/pdfBonDeRoute/'+ eventId);
                    newWindow.onload = function(){
                    newWindow.print();


                }
            });


        });
        var checkboxs = document.querySelectorAll('[id^="checkbox-"]');
        checkboxs.forEach(function(checkbox){
            checkbox.addEventListener('change', function(){
                var eventId = checkbox.id.split('-').pop();
                var tr = document.getElementById(eventId);
                var tds = tr.querySelectorAll('td');
                if (checkbox.checked === false) {
                    tds.forEach(function(td) {
                        td.style.backgroundColor = '';
                    });
                    axios.post('printBonDeRouteAjax', {
                        id: eventId,
                    })
                    .then(function (response) {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });

                }else if (checkbox.checked ){
                    tds.forEach(function(td) {
                        td.style.backgroundColor = 'green';
                    });
                    var newWindow = window.open('/documents/pdfBonDeRoute/'+ eventId);
                    newWindow.onload = function() {
                        newWindow.print();
                    };
                }
            });

       });



    </script>

@endsection
