@extends('base')
@section('title', 'E-mail')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
    </div>

    <ul class="nav nav-tabs mt-3 mb-4">
        <li class="nav-item">
            <button class="nav-link active " id="btnListe">Liste</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="btnForm">Nouveau</button>
        </li>
    </ul>

    @include('emails.mailContents.liste')
    @include('emails.mailContents.form')



@endsection
