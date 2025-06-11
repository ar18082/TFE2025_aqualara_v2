@extends('base')
@section('title', 'E-mail')
@section('content')
    <div class="container">
        @include('emails.mailContents.form')
    </div>

@endsection
