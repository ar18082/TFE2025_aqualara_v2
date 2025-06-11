@extends('base')

@section('title', 'Immeubles - ' . str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom)

@section('content')
<div class="container-fluid px-4 py-3">
    @if(Auth::check() && Auth::user()->role === 'admin')
    @include("shared.admin_header_immeuble")
    @else
    @include("shared.header_immeuble")
    @endif

    @if($appartements->isEmpty())
    <div id="importClients" class="card shadow-sm border-0 d-flex flex-row gap-2 p-2">
        <a href="{{route('documents.downloadExcelFormCreateApps', $client->id)}}" class="btn btn-outline-primary">
            <i class="fas fa-file-export me-2"></i>Exporter fichier vierge
        </a>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
            <i class="fa-solid fa-file-csv me-1"></i>Importer CSV
        </button>
    </div>
    <div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCsvModalLabel">Charger un fichier CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('immeubles.infoAppartUpdate.uploadCsv', $client->Codecli)}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Sélectionner un fichier CSV</label>
                            <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv" required>
                            <small class="text-muted">
                                <i class="fa-regular fa-circle-info me-1"></i>
                                Le fichier doit contenir les colonnes : Codecli, RefAppTR, RefAppCli, proprietaire,
                                datefin,
                                bloc
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Charger</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Liste des Appartements</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <span class="badge bg-primary rounded-pill px-4 py-2">
                    {{ $appartements->count() }} appartements
                </span>
            </div>
        </div>
    </div>

    <div class="appartements-container" id="data_container">
        <div class="card border-0 shadow-sm mb-3" id="entete_appartements">
            <div class="card-body p-0">
                <div class="row g-0 bg-primary text-light rounded-top">
                    <div class="col-lg-2 col-md-2 p-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Code</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 p-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Propriétaire</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 p-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Occupant</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 p-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Compteurs</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 p-3">
                        <div class="d-flex justify-content-end">
                            <span class="fw-bold">Actions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
        $bg_card_index = 0;
        @endphp

        @foreach($appartements as $appartement)

        @php

        $bg_card_index++;
        $bg_card = $bg_card_index % 2 == 0 ? 'bg-white' : 'bg-light';
        @endphp

        @include('immeubles.modalImmeubles')
        @include('immeubles.modalImages', ['numSerie' => false, 'value' => ''])
        @include('immeubles.appartements.listeAppartements')
        @endforeach
    </div>
</div>

@endsection


@endif