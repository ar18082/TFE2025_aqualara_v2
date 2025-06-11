@extends('base')
@section('content')
    <h1>{{$title}}</h1>

    <h2>Fichiers XML générés : correctement</h2>
    <ul>
        @foreach ($xmlFiles as $key => $xmlFile)

            <li>{{ $xmlFile->fileName}}</li>
        @endforeach
    </ul>
@endsection
