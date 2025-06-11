<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Rapport </title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>

        body{
            font-size: 12px;
            font-family: Arial, sans-serif;
        }

        header{
            margin-left: -3rem;
        }

        h3{
            margin: 0 1rem 0 0;
        }
        .date{
            margin-top: 0.5rem;
            margin-right: 0.5rem;
            text-align: right;
        }

        .main-content, .main-content_etatAvancement{
            border: 1px solid grey;
            margin-top: 0;
        }

        .container-InfoClient {
            margin: 2rem 0 1rem 0;
            position: relative;
            height: 10rem;
            border: 1px solid grey;
            padding-left: 1rem;

        }
        .contentInfoClient, .contentInfoMail {
            position: absolute;

        }
        .contentInfoClient {
            height: 8rem;
        }

        .contentInfoClient table , .contentInfoMail table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            text-align: left;
        }

        .contentInfoClient td{
             padding: 0 10px;
        }

        .contentInfoMail {
            height: 15rem;
            right: 6rem;
        }

        .contentInfoMail table{
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            text-align: left;
        }

        .contentInfoMail th,  .contentInfoMail td{
            text-align: left;
            padding:0 10px;
        }

        .header-container_main{
            background-color: #023062;
            color: white;
            padding: 0.5rem;
            border: 1px solid grey;
        }

        .container-main{
            position: relative;
            height: 20rem;
        }

        .contentCommande, .contentExecution, .contentExecutionFin{
            display: inline-block;
            width: 49%;
            position: absolute;

        }

        .contentCommande{
            left: 0;
        }

        .contentCommande table, .contentExecution table, .contentExecutionFin table{
            width: 100%;

        }

        .contentCommande th, .contentExecution th, .contentExecutionFin th{
            text-align: left;
            padding-left: 10px;
        }
        .contentCommande td, .contentExecution td, .contentExecutionFin td{
            text-align: right;
            padding-right: 10px;
        }

        .contentExecution{
            right: 0;
        }
        .contentExecutionFin{
            top: 13.5rem;
            right: 0;
        }

        .main-content_etatAvancement{
            margin-bottom: 2rem;
        }

        .main-content_etatAvancement table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .main-content_etatAvancement th, .main-content_etatAvancement td {
            border-left: none;
            border-right: 1px solid grey;
            border-top: none;
            border-bottom: none;


        }

        .main-contentInfoComplementaire{
            border: 1px solid grey;
            height: 10.5rem;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-container">
                <div class="header-logo">
                    <img src="{{public_path('img/bandeau-demande-de-prix.png')}}" height="110" width="" alt="logo">
                </div>
                <h3 class="date">Verviers, <span>{{\Carbon\Carbon::now()->format('d/m/Y')}}</span></h3>
            </div>
        </header>
        <main>
            <div class="container-InfoClient row mt-4">
                <div class="contentInfoClient">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Client : </strong></td>
                                <td>{{$client->nom}}</td>
                            </tr>
                            <tr>
                                <td><strong>Adresse : </strong></td>
                                <td>{{$client->rue}}</td>
                            </tr>
                            <tr>
                                <td><strong>Code postal : </strong></td>
                                <td>{{$client->codepost}}</td>
                            </tr>
                            <tr>
                                <td><strong>Ville : </strong></td>
                                <td>{{$client->codePostelbs[0]->Localite}}</td>
                            </tr>
                            <tr>
                                <td><strong>Téléphone : </strong></td>
                                <td>{{$client->tel??'Non renseigné'}}</td>
                            </tr>
                            <tr>
                                <td><strong>Période décompte : </strong></td>
                                <td>01-01-2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="contentInfoMail">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><strong>Nom Gérant : </strong></th>
                                <td>{{$client->gerant}}</td>
                            </tr>
                            <tr>
                                <th><strong>Ref. Client : </strong></th>
                                <td>{{$client->Codecli}}</td>
                            </tr>
                            <tr>
                                <th><strong>Adresse : </strong></th>
                                <td>{{$client->rueger??'Non renseigné'}}</td>

                            </tr>
                            <tr>
                                <th><strong>Tel : </strong></th>
                                <td>{{$client->telger??'Non renseigné'}}</td>
                            </tr>
                            <tr>
                                <th><strong>E-Mail : </strong></th>
                                <td>{{$client->Email??'Non renseigné'}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container-main">
                <div class="contentCommande">
                    <div class="header-container_main">
                        <h3 style="color:white; text-align: center">Commande</h3>
                    </div>
                    <div class="main-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th><strong>Appartement à équiper : </strong></th>
                                    <td>{{$devis->devisNbApp}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Répartiteurs de frais de chauffage (RFC)</strong></th>
                                    <td>{{$devis->devisNbRFC}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Compteurs eau chaude/froide</strong></th>
                                    <td>{{$devis->devisNbCptEau}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Intégrateurs </strong></th>
                                    <td>{{$devis->devisNbInteg}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Clapets anti-retour </strong></th>
                                    <td>{{$devis->devisAntiRetour}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Télérelève </strong></th>
                                    <td>{{$devis->devisTelereleve}}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="contentExecution">
                    <div class="header-container_main">
                        <h3 style="color:white; text-align: center">Exécution</h3>
                    </div>
                    <div class="main-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th><strong>Appartement terminés : </strong></th>
                                    <td>{{$execution->appTermine}}</td>
                                </tr>
                                <tr>
                                    <th><strong>RFC installés</strong></th>
                                    <td>{{$execution->rfcInstalles}}</td>
                                </tr>
                                <tr>
                                    <th><strong>RFC Sondes installés</strong></th>
                                    <td>{{$execution->rfcInstallesSondes}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Compteurs eau chaude installés</strong></th>
                                    <td>{{$execution->cptEauC}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Compteurs eau froide installés</strong></th>
                                    <td>{{$execution->cptEauF}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Intégrateurs installés </strong></th>
                                    <td>{{$execution->integrateurs}}</td>
                                </tr>
                                <tr>
                                    <th><strong>Clapets anti-retour  installés</strong></th>
                                    <td>{{$execution->anti_retour}}</td>
                                </tr>
                                @if($devis->devisTelereleve == 'YES')

                                <tr>
                                    <th><strong>Télérelève / % Réception </strong></th>
                                    <td>YES - EN COURS</td>
                                </tr>
                                <tr>
                                    <th><strong>Nbr boitiers télérelèves installés </strong></th>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="contentExecutionFin">
                    <div class="main-content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th><strong>Nombre de visites effectuées : </strong></th>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <th><strong>Nombres de vidanges effectuées :</strong></th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th><strong>Date de début des travaux : </strong></th>
                                    <td>28/11/2022</td>
                                </tr>
                                <tr>
                                    <th><strong>Date de fin des travaux :</strong></th>
                                    <td>28/11/2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contentFooter">
                <div class="contentEtatAvancement">
                    <div class="header-container_main">
                        <h3 style="color:white; text-align: center">Appartements non ou partiellement équipés</h3>
                    </div>
                    <div class="main-content_etatAvancement">
                        <table>
                            <thead>
                                <tr>
                                    <th>Appartement</th>
                                    <th>Appareils</th>
                                    <th>Raison</th>
                                    <th>Mise en ordre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>25</td>
                                    <td>0</td>
                                    <td>Compteurs non installés</td>
                                    <td>YES</td>
                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>0</td>
                                    <td>Compteurs non installés</td>
                                    <td>YES</td>
                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>0</td>
                                    <td>Compteurs non installés</td>
                                    <td>YES</td>
                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>0</td>
                                    <td>Compteurs non installés</td>
                                    <td>YES</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="contentInfoComplementaire">
                    <div class="header-container_main">
                        <h3 style="color:white; text-align: center">Info complémentaires - Finalisation chantier</h3>
                    </div>
                    <div class="main-contentInfoComplementaire"></div>
                </div>

        </main>
    </div>
</body>
</html>


