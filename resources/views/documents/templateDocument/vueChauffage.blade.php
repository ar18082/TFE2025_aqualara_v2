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
        }
        .container {
            width: 100%;
            margin: 1rem auto;
            text-align: center;
        }

        .header-logo{
            width: 100%;
        }
        .header-logo img{
            width: 100%;
            margin-bottom: 3rem;
        }

        .main-content {
            margin: 2rem 3rem 1rem 0 ;
        }


        .main-row h3 {

            text-align: center;
            margin: 1rem auto 1rem 2rem;

        }
        .main-row p {
            margin-left: 6rem;
            text-align: left;
        }

        .main-row h6 {
            margin:3rem 0 2rem 25rem;

        }

        .main-value {
            width: 100%;


        }

        .footer-logo img{
            margin-top: 7rem;
            width: 100%;

        }

    </style>

</head>
<body>
<div class="container">
    <header>
        <div class="header-container">
            <div class="header-logo">
                <img src="{{public_path('img/logo_aquatel.png')}}" alt="logo">
            </div>
        </div>
    </header>
    <main>
        <div class="main-title">
            <h2>chauffage</h2>
        </div>
        <div class="main-content">
            <h3>FRAIS A REPARTIR POUR L'IMMEUBLE </h3>
            <div class="main-row mt-5">
                <h3 class="main-value">test</h3>
                <h3 class="main-value">test</h3>
                <h3 class="main-value">test</h3>
                <h3 class="main-value">DU ../../.... AU ../../....  </h3>

            </div>
            <div class="main-row mt-2">
                <table>
                    <tbody>

                        <tr>
                            <td>STOCK DE DEPART CITERNE</td>
                            <td>.........</td>
                        </tr>
                        <tr>
                            <td>ACHAT COMBUSTIBLE</td>
                            <td>.........</td>
                        </tr>
                        <tr>
                            <td>SOLDE CITERNE A DEDUIRE</td>
                            <td>.........</td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>TOTAL GENERAL</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><h3>EAU</h3></td>
                        </tr>
                        <tr>
                            <td>PRIX D'1 HL EAU FROIDE</td>
                            <td>.........</td>
                        </tr>
                        <tr>
                            <td>PRIX D'1 HL EAU CHAUDE</td>
                            <td>.........</td>
                        </tr>
                        <tr>
                            <td>REDEVANCE PAR APPARTEMENT</td>
                            <td>.........</td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><h3>OU</h3></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>MONTANT FACTURE EAU</td>
                            <td>.........</td>
                        </tr>

                    </tbody>
                </table>
                <h3>FRAIS DIVERS</h3>
                <p>AQUATEL IMPUTERA DIRECTEMENT LES FRAIS DE RELEVE DANS LE DECOMPTE</p>
                <p>...............................................................................</p>
            </div>

            <div>
                <h6>DATE: ../../....</h6>
                <h6> NOM: ................</h6>
                <h6> SIGNATURE: ................</h6>
            </div>

        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <img src="{{public_path('img/footer_aquatel.png')}}" alt="footer">
            </div>

{{--            @if($btnReturn)--}}
{{--                <a class="btn btn-primary mt-4" href="{{ route('immeubles.show', $event->client->Codecli) }}">Retour</a>--}}
{{--            @endif--}}

        </div>

    </footer>
</div>
</body>
</html>


