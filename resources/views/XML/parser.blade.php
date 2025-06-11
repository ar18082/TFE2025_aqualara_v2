@extends('base')
@section('content')
    <h1>{{$title}}</h1>

    <h1>un fichier à la fois</h1>

    <form action="{{ route('parserXmlFile') }}" method="POST" enctype="multipart/form-data" >
        @csrf

        <input type="file" name="file">

        <button type="submit">Envoyer</button>
    </form>


@endsection
