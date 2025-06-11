@extends('base')
@section('title', 'Liste SDC ')
@section('content')
    <form action="{{route('documents.listeSDC.store')}}" method="post" class="m-5">
        @csrf
        <select name="month">
            <option value="00">Sélectionner un mois</option>
            <option value="01">Janvier</option>
            <option value="02">Février</option>
            <option value="03">Mars</option>
            <option value="04">Avril</option>
            <option value="05">Mai</option>
            <option value="06">Juin</option>
            <option value="07">Juillet</option>
            <option value="08">Août</option>
            <option value="09">Septembre</option>
            <option value="10">Octobre</option>
            <option value="11">Novembre</option>
            <option value="12">Décembre</option>
        </select>
        <button type="submit">Submit</button>
    </form>


{{--    affichage liste SDC avec l'année la plus récente en top liste--}}

    @if(!empty($documents))
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Date</th>
                <th scope="col">Lien</th>
                <th scope="col">Action</th>


            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{ $document->id}}</td>
                    <td>{{ \Carbon\Carbon::parse($document->send_at)->format('d-m-Y') }}</td>
                    <td>{{ $document->link}}</td>
                    <td>
                        <div class="d-inline ">
                            <a href="{{route('documents.printListeSDC', $document->id)}}" class="btn btn-primary"><i class="fa fa-download"></i></a>
                        </div>
                        <div class="d-inline ">
                            <a href="{{route('documents.showListeSDC', $document->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
