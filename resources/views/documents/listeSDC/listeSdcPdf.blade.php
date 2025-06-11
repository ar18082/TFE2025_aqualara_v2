<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Bon de route </title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>

        @page {
            size: A4 landscape;
            margin: 10mm;

        }
        body {

            font-size: 18px;
            margin: 1rem;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 16px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }




    </style>

</head>
<body>
<header>

</header>
<main>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">DC</th>
            <th scope="col">DT</th>
            <th scope="col">Reference</th>
            <th scope="col">Nom du client </th>
            <th scope="col">Adresse</th>
            <th scope="col">Localité</th>
            <th scope="col">Commentaire</th>

        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $client->Codecli }}</td>
                <td>{{ $client->nom }}</td>
                <td>{{ $client->rue }}</td>
                <td>{{$client->codepost}} {{$client->codePostelbs[0]->Localite}}</td>
                <td>{{$client->remarque}}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
</main>



</body>
</html>


