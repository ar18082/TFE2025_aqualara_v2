@extends('base')

@section('title', 'Immeubles - ' . str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom)

@section('content')
<div class="container-fluid px-4 py-3">
    @if(Auth::check() && Auth::user()->role === 'admin')
    @include("shared.admin_header_immeuble")
    @else
    @include("shared.header_immeuble")
    @endif

    @include('immeubles.appartements.index')
</div>

@endsection