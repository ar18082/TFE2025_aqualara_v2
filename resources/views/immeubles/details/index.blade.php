@extends('base')

@section('title', 'Immeubles - ' . str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom)

@section('content')
@if(Auth::check() && Auth::user()->role === 'admin')
@include("shared.admin_header_immeuble")
@else
@include("shared.header_immeuble")
@endif

<div id="detailContent" class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.details', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.details') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-info-circle me-2"></i>Definition
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.graphiques', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.graphiques') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-chart-line me-2"></i>Graphiques
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.chauffage', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.chauffage') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-fire me-2"></i>Chauffage
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.eau', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.eau') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-tint me-2"></i>Eau
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.gaz', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.gaz') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-gas-pump me-2"></i>Gaz
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.electricite', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.electricite') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-bolt me-2"></i>Electricité
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.provision', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.provision') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-money-bill-wave me-2"></i>Provision
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('immeubles.infoAppart', $client->Codecli) }}"
                    class="nav-link {{ request()->routeIs('immeubles.details.infoAppart') ? 'active' : '' }}"
                    role="tab">
                    <i class="fas fa-building me-2"></i>Info Appart.
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            @include($content)
        </div>
    </div>
</div>
@endsection