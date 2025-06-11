<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield("title") | Administration</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <link href="/css/fontawesome-pro-6.5.1-web/css/all.css" rel="stylesheet">
        <style>

            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                width: 99%;

                line-height: 1.5;
            }

            .header, .footer{
                text-align: center;
                position: fixed;
                width: 100%;
            }

            .header {
                top: 0;
            }

            .header-logo{
                width: 100%;
            }
            .header-logo img{
                width: 100%;
                margin-bottom: 3rem;
            }

            .header-content {
                margin: 2rem 3rem 1rem 0 ;
            }

            .content {
                margin: 25rem 2rem 0 2rem;
            }

            .main-content {
                margin: 2rem 3rem 1rem 0 ;
            }
            .main-row h3 {
                text-align: center;
                margin: 1rem auto 1rem 2rem;
            }

            #date{
                text-align: center;
            }

            .main-value {
                width: 100%;
            }

            .footer {
                bottom: 0;

            }

            .footer-signature p{
                margin-left: 6rem;
                text-align: left;

            }

            .footer-signature h6 {
                margin:3rem 0 2rem 25rem;

            }

            .footer-logo img{
                margin-top: 2rem;
                margin-bottom: 0;
                width: 100%;

            }

        </style>

    </head>
    <body>
        <header class="header">
            <div class="header-container">
                <div class="header-logo">
                    <img src="{{public_path('img/logo_aquatel.png')}}" alt="logo">
                </div>
            </div>
            <div class="header-title">
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
        @if($avisPassageText)
        <main class="content">
            <div class="main-content">
                <div class="main-row mt-2">
                    <p>La société AQUATEL procédera au {{$avisPassageText->typePassage ? mb_strtoupper($avisPassageText->typePassage, 'UTF-8') : ''}} le :</p>

                    <h3 id="date">{{ \Carbon\Carbon::parse($event->start)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                        @if($event->quart == 'AM')
                            entre 08h30 et 12h30
                        @elseif($event->quart == 'PM')
                            entre 13h30 et 17h00
                        @else
                            entre 08h30 et 17h00
                        @endif
                    </h3>
                </div>
                <div class="main-row content_text mt-2">

                        <p> {{$avisPassageText->acces != null ? $avisPassageText->acces : '' }}</p>
                        <p> {{$avisPassageText->presence != null ? $avisPassageText->presence : ''}}</p>
                        <p style="color: red"> {{$avisPassageText->coupure != null ? $avisPassageText->coupure : ''}}</p>




                </div>

            </div>
        </main>
        @endif
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-signature">
                    <p>Nous vous remercions pour votre collaboration,</p>
                    <h6>AQUATEL</h6>
                </div>
                <div class="footer-logo">
                    <img src="{{public_path('img/footer_aquatel.png')}}" alt="footer">
                </div>
            </div>
        </footer>
    </body>
</html>


