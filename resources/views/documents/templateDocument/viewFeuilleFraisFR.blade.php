<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Aquatel | Formulaire</title>
    <style>

        @page {
            size: A4;

        }
        body {
           width: 100%;
            margin: 0;
        }
        header {
            margin: 0;
            display: block;
            font-size: 12px;

        }
        main {
            font-size: 12px;
            color: #1f3868;

        }

        header h1 {
            position: absolute;
            margin-left: 1.5%;
            margin-top: 2%;
            color: white;
            font-size: 16px;
        }

        h2 {
            color: white;
            font-size: 16px;
            text-align: center;
            padding : 0;
            margin: 2px 0 0 0;
        }

        span{
            color: grey;
        }

        input[type="checkbox"] {
            position: relative;
            top: 5px;
        }

        input[type="text"] {
           padding: 10px 3px;
        }

        footer {
            width: 100%;
            font-size: 12px;
            color: #1f3868;
            margin: 2rem 0 0 2rem;
            padding: 0;
        }

        footer p {
            font-size: 12px;
            margin: 1.5rem 0 0 0;
            padding: 0;
            color: grey;
        }

        .aquatel{
            width: 18%;

        }
        .blue_banner{
            width: 80%;
        }

        .table_InfoClient {
            border: 1px solid #1f3868;
            width: 100%;
        }

        .table_InfoClient th{
            background-color: #1f3868;
            color: white;
            text-align: center;
        }

       .table_InfoClient td{
            text-align: left;
            border: 1px solid #1f3868;
            padding-left: 10px;
       }

        .title_table_depChauffage {
            background-color: #1f3868;
            width: 100%;
            height: 30px;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }

        .table_depChauffage {
            width: 100%;
            border : 1px solid #1f3868;
            border-collapse: collapse;
            padding: 0 0 1rem 0;
            height: auto;

        }

        .table_depChauffage th {
            text-align: center;
            border-left: 1px solid #1f3868;
        }

        .table_depChauffage td:nth-child(1) {
            width: 350px;
            padding-left: 1rem;
        }

        .table_depChauffage td:nth-child(2) {
            border-left: 1px solid #1f3868;
            text-align: center;
            width: 84px;
        }
        .table_depChauffage td:nth-child(3) {
            border-left: 1px solid #1f3868;
            text-align: center;
            width: 84px;
        }

        .table_depChauffage td:nth-child(4) {
            border-left: 1px solid #1f3868;
            text-align: center;
            width: 84px;
        }

        .repartition {
            margin: 0 ;

        }

        .repartition h3 {
            margin: 0;
            padding: 0;
        }


        .table_Repartion tr:nth-child(2) {
            padding-top: 1rem;
            text-align: center;
        }

        .down_whitezone{
            border: 1px solid #1f3868;
            margin-top: 1rem;
            padding: 0 0 1rem 0;

        }

        .down_title {
            margin: 0;
            width: 100%;
            height: 25px;
            background-color: #1f3868;
        }

        .down_title h2 {
            margin: 0 0 0 0 ;
            padding: 0;
        }

        .down_whitezone_body {
            padding: 0 0 0 1rem;
        }

    </style>
</head>
<body>
    <header>
        <div>
            <h1>FORMULAIRE POUR LA RÉPARTITION DES FRAIS <br/>DE CHAUFFAGE</h1>
            <img alt="second logo of the company" class="blue_banner" src="{{public_path('img/ruban_header.png')}}">
            <img alt="logo of the company" class="aquatel" src="{{public_path('img/logo_rond.PNG')}}">
        </div>
    </header>
    <main>
        <table class="table_InfoClient">
            <thead>
                <tr>
                    <th>Adresse gérance</th>
                    <th>Période de chauffe</th>
                    <th>Immeuble</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p><span>Gérant : </span>{{$event->client->gerant}} </p>
                        <p><span>Adresse :</span>{{$event->client->rueger}}</p>
                        <p><span>Localité :</span> {{$event->client->codepostger . ' ' . $localiteGer}} </p>
                    </td>
                    <td>
                        <p><span>du :</span></p>
                        <p><span>au :</span></p>
                    </td>
                    <td>
                        <p><span>Client : </span> {{$event->client->nom}} </p>
                        <p><span>Code Client : </span>{{$event->client->Codecli}} </p>
                        <p><span>Adresse : </span>{{$event->client->rue}}</p>
                        <p><span>Localité : </span>{{$event->client->codepost . ' ' . $localite}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="content_depChauffage">
            <div class="title_table_depChauffage">
                <h2>Dépenses chauffage</h2>
            </div>
            <table class="table_depChauffage">
                <thead>
                    <tr>
                        <th></th>
                        <th>Quantité</th>
                        <th>Prix Unit.</th>
                        <th>€</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Stock de combustilble au début de la période de chauffe (si mazout)</td>
                        <td>........</td>
                        <td>........</td>
                        <td>........</td>
                    </tr>
                    <tr>
                        <td>2. Achat de combustible (mazout/gaz)</td>
                        <td>........</td>
                        <td>........</td>
                        <td>........</td>
                    </tr>
                    <tr>
                        <td>3. Frais entretien (chaudière, brûleur)</td>
                        <td>........</td>
                        <td>........</td>
                        <td>........</td>
                    </tr>
                    <tr>
                        <td>4. Frais électricité chaudière</td>
                        <td>........</td>
                        <td>........</td>
                        <td>........</td>
                    </tr>
                    <tr>
                        <td>5. A déduire : Stock de combustible en fin de période de chauffe (si mazout)</td>
                        <td>........</td>
                        <td>........</td>
                        <td>........</td>
                    </tr>
                    <tr>
                        <td>6. Total des frais à répartir (1+2+3+4-5) </td>
                        <td></td>
                        <td></td>
                        <td><input type="text"></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="repartition">
            <h3>Mode de répartition</h3>
            <table class="table_Repartition">
                <tr>
                    <td>
                        <input type="checkbox">Uniquement suivant relevé des unités (peu conseillé, car ne tient pas compte des déperditions communes de chaleur) OU                </td>
                </tr>

                <tr>
                    <td>
                        <input type="checkbox">En déduisant une part à titre de frais fixes du total (6. ci-dessus) :  soit sous forme d'une pourcentage <input type="text" style="position: relative; top: 0.5rem">
                    </td>
                </tr>
            </table>
            <div style="text-align: right; margin-right: 2.8rem"> soit sous forme d'un montant  <input type="text" style="position: relative; top: 0.5rem">
        </div>
        <div class="down_whitezone" >
            <div class="down_title">
                <h2>Dépense eau</h2>
            </div>
            <div class="down_whitezone_body">
                 <table>
                    <tr>
                        <td style="margin: 0 2px 0 0">Montant eau froide suivant facture :</td>
                        <td><input type="text"></td>
                        <td>ou</td>
                        <td>Prix unitaire 1 HL eau froide à appliquer : </td>
                        <td><input type="text" style="position: relative; right: 1rem; margin: 0"></td>
                    </tr>
                </table>
                <div>
                    <h3 style="text-align: center">Réchauffement de l'eau</h3>
                    <div class="down_whitezone_body_text_up">
                        <div>Si chaudière unique pour chauffage et au chauge : <input type="checkbox"> Prix unitaire du réchauffement de 1HL d'eau à appliquer</div>
                        <div style="text-align: right; margin-right: 0.5rem">__________________________</div>
                        <div style="text-align: right; margin-right: 8rem"><input type="checkbox"> OU : Proposition forfétaire appliquée généralement par Aquatel</div>
                        <div style="text-align: right; font-size: 10px; color: grey; margin-right: 8rem">(valeur de 1 HL eau chaude = +- 1HL eau froide + côut de 1,5 m3 de gaz ou de mazout)</div>
                    </div>


                </div>
            </div>
        </div>
        <div class="down_whitezone">
            <div class="down_title">
                <h2>Frais divers</h2>
            </div>
            <div class="down_whitezone_body">
                <div style="padding: 1rem 0 0 0">
                    <span> Libellé rubrique :______________________________</span> <span style="margin-left: 1rem">Montant à répartir :______________________________</span>
                </div>
                <div>
                    Ces frais seront répartis entre les occupants : <input type="checkbox"> suivant QUOTITES* OU <input type="checkbox"> suivant PARTS EGALE
                </div>
                <p>Si plusieurs rubriques, mentionnez-les sur une feuille séparée <br/>
                        * a communiquer au verso
                </p>
            </div>
        </div>
    </main>
    <footer>
        <p>Date :______________________________________________________ <span style="margin-left: 2rem">Signature :</span></p>
        <p>E-mail :______________________________________________________ </p>
    </footer>
</body>
</html>
