@extends('decompte.word.templates.base')

@section('title', 'Exemple de Document')

@section('header')
    <h1>Exemple de Document</h1>
    <p>Date: {{ date('d/m/Y') }}</p>
@endsection

@section('content')
    <div class="section">
        <h2>Informations Générales</h2>
        <table>
            <tr>
                <th>Champ</th>
                <th>Valeur</th>
            </tr>
            <tr>
                <td>Nom</td>
                <td>{{ $nom ?? 'Non spécifié' }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ $date ?? date('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Détails</h2>
        <table>
            <tr>
                <th>Description</th>
                <th>Montant</th>
            </tr>
            @foreach($details ?? [] as $detail)
            <tr>
                <td>{{ $detail['description'] }}</td>
                <td>{{ $detail['montant'] }} €</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('footer')
    <p>Document généré automatiquement</p>
    <p>Page 1/1</p>
@endsection 