@extends('admin.base')
@section('title', $events ? 'Liste d\'évènements' : 'Ajouter un évènement')
@section('content')
    <div class="col-11" style="margin: 1rem auto">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
        </div>
        <form id="formEvent">
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
                    <div class="text-light">Type d'intervention</div>
                    <div class="input-group input-group-sm">
                        <select type="text" class="form-control TypeInter" id="TypeInter" name="TypeInter"></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-light">Date</div>
                    <div class="input-group input-group-sm">
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                </div>
                <div class="col-md-2 m-2">
                    <button type="submit" id="submitFormEvent" style="display: block">Rechercher</button>
                </div>
            </div>
        </form>

        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <button class="nav-link active " id="btnToDay" >Aujourd'hui</button>
            </li>
            <li class="nav-item">
                <button class="nav-link " id="btnPlanifier" >Planifier</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="btnAPlanifier">A planifier</button>
            </li>
            <li class="nav-item">
                <a class="nav-link"  id="btnNouveau" href="{{ route('admin.event.create') }}">Nouveau</a>
            </li>

        </ul>

        <table class="table table-striped" id="RDVImmeuble">
            <thead>
            <tr>

                <th>Date</th>
                <th>Quart</th>
                <th>CodeCli</th>
                <th>Nom Client</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Intervention</th>
                <th>Technicien</th>
                <th>Commentaire</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody id="tBody_Event">
            @foreach($nowEvents as $nowEvent)
                <tr>
                    <td>{{ Carbon\Carbon::parse($nowEvent->start)->format('d-m-Y H:i')}}</td>
                    <td>{{ $nowEvent->quart }}</td>
                    <td>{{ $nowEvent->client->Codecli }}</td>
                    <td>{{ $nowEvent->client->nom }}</td>
                    <td>{{ $nowEvent->client->rue }}</td>
                    <td>{{ $nowEvent->client->codepost }}</td>
                    <td>{{ $nowEvent->typeEvent->name }}</td>
                    <td>
                        @if($nowEvent->techniciens->count() > 0)
                            @foreach($nowEvent->techniciens as $technicien)
                                {{ $technicien->nom }} {{ $technicien->prenom }}
                            @endforeach
                        @else
                            <span class="text-danger">Pas de technicien</span>
                        @endif

                    </td>
                    <td>{{ $nowEvent->commentaire }}</td>
                    <td class="text-end col-2">
                        <div class="d-inline ">
                            <a href="/cartography?date={{$nowEvent->start}}{{$nowEvent->techniciens->count() > 0 ?'&techId='.$nowEvent->techniciens[0]->id : ''}}" class="btn btn-primary"><i class="fa-solid fa-map"></i></a>
                        </div>
                        <div class="d-inline ">
                            <a href="/calendar?date={{$nowEvent->start}}" class="btn btn-primary"><i class="fa-solid fa-calendar"></i></a>
                        </div>
                        <div class="d-inline">
                            <a href="{{ route('admin.event.edit', $nowEvent->id) }}" class="btn btn-primary"><i class="fa-solid fa-pen"></i></a>
                        </div>
                        <div class="d-inline">
                            <form action="{{ route('admin.event.destroy', $nowEvent->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
            <tbody id="tBody_FuturEvent">
            @foreach($events as $event)
                <tr>
                    <td>{{ Carbon\Carbon::parse($event->start)->format('d-m-Y H:i')}}</td>
                    <td>{{ $event->quart }}</td>
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
                    <td class="text-end col-2">
                        <div class="d-inline ">
                            <a href="/cartography?date={{$event->start}}{{$event->techniciens->count() > 0 ?'&techId='.$event->techniciens[0]->id : ''}}" class="btn btn-primary"><i class="fa-solid fa-map"></i></a>
                        </div>
                        <div class="d-inline ">
                            <a href="/calendar?date={{$event->start}}" class="btn btn-primary"><i class="fa-solid fa-calendar"></i></a>
                        </div>
                        <div class="d-inline">
                            <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-primary"><i class="fa-solid fa-pen"></i></a>
                        </div>
                        <div class="d-inline">
                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
            <tbody id="tBody_PlanifEvent">
            @foreach($eventsPlanify as $eventPlanify)
                <tr>
                    <td>{{ $eventPlanify->start}}</td>
                    <td>{{ $eventPlanify->client->Codecli }}</td>
                    <td>{{ $eventPlanify->client->nom }}</td>
                    <td>{{ $eventPlanify->client->rue }}</td>
                    <td>{{ $eventPlanify->client->codepost }}</td>
                    <td>{{ $eventPlanify->typeEvent->name }}</td>
                    <td>
                        @foreach($eventPlanify->techniciens as $technicien)
                            {{ $technicien->nom }} {{ $technicien->prenom }}
                        @endforeach
                    </td>
                    <td>{{ $eventPlanify->commentaire }}</td>
                    <td class="text-end col-2">
                        <div class="d-inline ">
                            <a href="/cartography?date={{$eventPlanify->start}}{{$eventPlanify->techniciens->count() > 0 ?'&techId='.$eventPlanify->techniciens[0]->id : ''}}" class="btn btn-primary"><i class="fa-solid fa-map"></i></a>
                        </div>
                        <div class="d-inline ">
                            <a href="/calendar?date={{$eventPlanify->start}}" class="btn btn-primary"><i class="fa-solid fa-calendar"></i></a>
                        </div>
                        <div class="d-inline">
                            <a href="{{ route('admin.event.edit', $eventPlanify->id) }}" class="btn btn-primary"><i class="fa-solid fa-pen"></i></a>
                        </div>
                        <div class="d-inline">
                            <form action="{{ route('admin.event.destroy', $eventPlanify->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
        {{ $events->links() }}
    </div>
<script>
    var tbody_event = document.getElementById('tBody_Event');
    var tBody_FuturEvent = document.getElementById('tBody_FuturEvent');
    var tBody_PlanifEvent = document.getElementById('tBody_PlanifEvent');
    var btnToDay = document.getElementById('btnToDay');
    var btnAPlanifier = document.getElementById('btnAPlanifier');
    var btnPlanifier = document.getElementById('btnPlanifier');
    var btnNouveau = document.getElementById('btnNouveau');

    tBody_PlanifEvent.style.display = 'none';
    tBody_FuturEvent.style.display = 'none';
    tbody_event.style.display = 'table-row-group';

    btnToDay.addEventListener('click', function() {

        btnToDay.style.backgroundColor = '#023c7b';
        btnToDay.style.color = 'white';

        btnAPlanifier.style.backgroundColor = 'white';
        btnAPlanifier.style.color = '#023c7b';


        btnPlanifier.style.backgroundColor = 'white';
        btnPlanifier.style.color = '#023c7b';

        tBody_FuturEvent.style.display = 'none';
        tBody_PlanifEvent.style.display = 'none';
        tbody_event.style.display = 'table-row-group';
    });

    btnAPlanifier.addEventListener('click', function() {

        btnAPlanifier.style.backgroundColor = '#023c7b';
        btnAPlanifier.style.color = 'white';

        btnToDay.style.backgroundColor = 'white';
        btnToDay.style.color = '#023c7b';


        btnPlanifier.style.backgroundColor = 'white';
        btnPlanifier.style.color = '#023c7b';

        tBody_FuturEvent.style.display = 'none';
        tBody_PlanifEvent.style.display = 'table-row-group';
        tbody_event.style.display = 'none';
    });
    btnPlanifier.addEventListener('click', function() {
        btnPlanifier.style.backgroundColor = '#023c7b';
        btnPlanifier.style.color = 'white';

        btnToDay.style.backgroundColor = 'white';
        btnToDay.style.color = '#023c7b';

        btnAPlanifier.style.backgroundColor = 'white';
        btnAPlanifier.style.color = '#023c7b';

        tBody_FuturEvent.style.display = 'table-row-group';
        tBody_PlanifEvent.style.display = 'none';
        tbody_event.style.display = 'none';
    });
    btnNouveau.addEventListener('click', function() {
        btnPlanifier.style.backgroundColor = 'white';
        btnPlanifier.style.color = '#023c7b';

        btnToDay.style.backgroundColor = 'white';
        btnToDay.style.color = '#023c7b';

        btnAPlanifier.style.backgroundColor = 'white';
        btnAPlanifier.style.color = '#023c7b';

        tBody_FuturEvent.style.display = 'none';
        tBody_PlanifEvent.style.display = 'none';
        tbody_event.style.display = 'none';
    });
</script>
@endsection
