@extends('base')
@section('title', 'Avis passage text')
@section('content')


    <a href="{{route('admin.avisPassageText.create')}}" class="btn btn-primary m-2">Créer</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Type Event</th>
            <th scope="col">Type releve</th>
            <th scope="col">Type Passage</th>
            <th scope="col">Accès</th>
            <th scope="col">Présence</th>
            <th scope="col">Coupure</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($avisPassageTexts as $avisPassageText)
            <tr>
                <th scope="row">{{$avisPassageText->id}}</th>
                <td>{{$avisPassageText->TypeEvent->abreviation}}</td>
                <td>{{$avisPassageText->TypRlv}}</td>
                <td>{{$avisPassageText->typePassage}}</td>
                <td>{{$avisPassageText->acces}}</td>
                <td>{{$avisPassageText->presence}}</td>
                <td>{{$avisPassageText->coupure}}</td>
                <td class="text-end">
                    <a href="{{ route('admin.avisPassageText.edit', $avisPassageText->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.avisPassageText.destroy', $avisPassageText->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce contenu ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection
