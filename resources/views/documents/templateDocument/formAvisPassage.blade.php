{{-- il faut générer un formulaire qui reprends les informations importantes pour la génération de l'avis de passage. --}}
@extends('base')
@section('title', 'Modifier avis de passage')
@section('content')
    <div style="width: 80%; margin: 1rem auto">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-4">@yield('title')</h1>
            <a href="{{-- route('immeubles.show', $event->client->Codecli) --}}" class="btn btn-secondary">Retour</a>
        </div>
        <form action="{{route('documents.updateDocument')}}" method="POST" style="background-color: white">
            @csrf
            <input type="hidden" name="type" value="{{$type}}">
            <input type="hidden" name="event_id" value="{{$event->id}}">
            <header class="header mt-2" style="text-align: center; padding: 4rem">
                <div class="header-container">
                    <div class="header-logo">
                        <img src="{{asset('img/logo_aquatel.png')}}" alt="logo">
                    </div>
                </div>
                <div class="header-title mt-4">
                    <h2>NOTE AUX OCCUPANTS DE L'IMMEUBLE:</h2>
                </div>
                <div class="header-content">
                    <div class="main-row mt-5">
                        <h3 class="main-value">{{$event->client->nom}}</h3>
                        <h3 class="main-value">{{$event->client->rue}}</h3>
                        <h3 class="main-value">{{$event->client->codepost . ' ' . $localite}}  </h3>

                    </div>
                </div>
            </header>
            <main class="content">
                <div class="main-content">
                    <div class="main-row mt-2">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <p>La société AQUATEL procédera au </p>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-5">
                                <input type="text" class="form-control" name="typePassage" value="{{$avisPassageText->typePassage}}">
                            </div>
                            <div class="col-4"></div>
                            <div class="col-2 mt-4">
                                <p>le :</p>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-3"></div>
                            <div class="col-6">
                                <h3 id="date">{{ \Carbon\Carbon::parse($event->start)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                    @if($event->quart == 'Matin')
                                        entre 08h30 et 12h30
                                    @elseif($event->quart == 'Après-midi')
                                        entre 13h30 et 17h00
                                    @else
                                        entre 08h30 et 17h00
                                    @endif
                                </h3>
                            </div>

                        </div>
                    </div>
                    <div class="row content_text mt-2">
                        <div class="col-3"></div>
                        <div class="col-6">
                                <label for="acces">Accès aux compteurs :</label>
                                <textarea  class="mt-2"  name="acces"    style="height: 100px; width: 100%">{{$avisPassageText->acces}}    </textarea>
                                <label for="presence">Présence des résidents :</label>
                                <textarea  class="mt-2"  name="presence" style="height: 100px; width: 100%">{{$avisPassageText->presence}} </textarea>
                                <label for="coupure">Coupure prévue :</label>
                                <textarea  class="mt-2"  name="coupure"  style="height: 100px; width: 100%">{{$avisPassageText->coupure}}  </textarea>

                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer mt-5">
                <div class="footer-container">
                    <div class="footer-signature row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <p>Nous vous remercions pour votre collaboration,</p>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-9"></div>
                        <div class="col-2">
                            <h6 style="font-size: 16px; font-weight: bold; ">AQUATEL</h6>
                        </div>
                    </div>
                    <div class="footer-logo" style="text-align: center;">
                        <img src="{{asset('img/footer_aquatel.png')}}" alt="footer" style="width: 60%">
                    </div>
                </div>
            </footer>
            <div class="d-flex justify-content-left mt-5" style="margin-left: 6rem">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>

    {{--                        <h3 id="date">{{ \Carbon\Carbon::parse($event->start)->isoFormat('dddd D MMMM YYYY') }} entre {{ \Carbon\Carbon::parse($event->start)->format('H\hi') }} et {{ \Carbon\Carbon::parse($event->end)->format('H\hi') }} </h3>--}}

@endsection
