@extends('base')

@section('content')
<div class="container-fluid px-4 py-3">
    @include("shared.admin_header_immeuble")

    <div class="row mt-4" >
        <div class="col-12" ">
            <div class="card shadow-sm" >
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Documents de l'immeuble</h5>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter un document
                        </button>
                    </div>
                </div>
                <div class="card-body" style="height: 70vh; overflow-y: auto;">
                    <!-- Navigation des filtres -->
                    <ul class="nav nav-tabs mb-4" id="documentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                type="button" role="tab">
                                <i class="fas fa-folder me-2"></i>Tous
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bon-tab" data-bs-toggle="tab" data-bs-target="#bon"
                                type="button" role="tab">
                                <i class="fas fa-receipt me-2 text-primary"></i>Bons de route
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="avis-tab" data-bs-toggle="tab" data-bs-target="#avis"
                                type="button" role="tab">
                                <i class="fas fa-clipboard-list me-2 text-success"></i>Avis de passage
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rapport-tab" data-bs-toggle="tab" data-bs-target="#rapport"
                                type="button" role="tab">
                                <i class="fas fa-file-alt me-2 text-info"></i>Rapports
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="repartition-tab" data-bs-toggle="tab"
                                data-bs-target="#repartition" type="button" role="tab">
                                <i class="fas fa-chart-pie me-2 text-warning"></i>Fiches de répartition
                            </button>
                        </li>
                    </ul>

                    <!-- Contenu des onglets -->
                    <div class="tab-content" id="documentTabsContent">
                        <!-- Onglet Tous -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="row g-4">
                                @if($documents->count() > 0)
                                @foreach($documents as $document)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body" >
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="document-icon bg-light rounded-circle p-3 me-3">
                                                    @switch($document->type)
                                                    @case('Bon de route')
                                                    <i class="fas fa-receipt text-primary fa-2x"></i>
                                                    @break
                                                    @case('Avis de passage')
                                                    <i class="fas fa-clipboard-list text-success fa-2x"></i>
                                                    @break
                                                    @case('Rapport')
                                                    <i class="fas fa-file-alt text-info fa-2x"></i>
                                                    @break
                                                    @case('Fiche de répartition')
                                                    <i class="fas fa-chart-pie text-warning fa-2x"></i>
                                                    @break
                                                    @default
                                                    <i class="fas fa-file text-secondary fa-2x"></i>
                                                    @endswitch
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $document->type }}</h6>
                                                    <small class="text-muted">{{
                                                        \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Ajouté le {{
                                                    \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                    }}</small>
                                                <div class="dropdown" style="height: 10rem;">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" >
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.download', $document->id) --}}">
                                                                <i class="fas fa-download me-2"></i>Télécharger
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.edit', $document->id) --}}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{-- route('documents.destroy', $document->id) --}}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>Aucun document disponible</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Onglet Bons de route -->
                        <div class="tab-pane fade" id="bon" role="tabpanel">
                            <div class="row g-4">
                                @php
                                $bonsRoute = $documents->filter(function($doc) { return $doc->type === 'Bon de route';
                                });
                                @endphp
                                @if($bonsRoute->count() > 0)
                                @foreach($bonsRoute as $document)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="document-icon bg-light rounded-circle p-3 me-3">
                                                    <i class="fas fa-receipt text-primary fa-2x"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $document->type }}</h6>
                                                    <small class="text-muted">{{
                                                        \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Ajouté le {{
                                                    \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                    }}</small>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.download', $document->id) --}}">
                                                                <i class="fas fa-download me-2"></i>Télécharger
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.edit', $document->id) --}}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{-- route('documents.destroy', $document->id) --}}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-receipt fa-3x mb-3 text-primary"></i>
                                        <p>Aucun bon de route disponible</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Onglet Avis de passage -->
                        <div class="tab-pane fade" id="avis" role="tabpanel">
                            <div class="row g-4">
                                @php
                                $avisPassage = $documents->filter(function($doc) {
                                return $doc->type === 'Avis de passage';
                                });
                                @endphp
                                @if($avisPassage->count() > 0)
                                @foreach($avisPassage as $document)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="document-icon bg-light rounded-circle p-3 me-3">
                                                    <i class="fas fa-clipboard-list text-success fa-2x"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $document->type }}</h6>
                                                    <small class="text-muted">{{
                                                        \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Ajouté le {{
                                                    \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                    }}</small>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.download', $document->id) --}}">
                                                                <i class="fas fa-download me-2"></i>Télécharger
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.edit', $document->id) --}}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{-- route('documents.destroy', $document->id) --}}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3 text-success"></i>
                                        <p>Aucun avis de passage disponible</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Onglet Rapports -->
                        <div class="tab-pane fade" id="rapport" role="tabpanel">
                            <div class="row g-4">
                                @php
                                $rapports = $documents->filter(function($doc) {
                                return $doc->type === 'Rapport';
                                });
                                @endphp
                                @if($rapports->count() > 0)
                                @foreach($rapports as $document)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="document-icon bg-light rounded-circle p-3 me-3">
                                                    <i class="fas fa-file-alt text-info fa-2x"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $document->type }}</h6>
                                                    <small class="text-muted">{{
                                                        \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Ajouté le {{
                                                    \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                    }}</small>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.download', $document->id) --}}">
                                                                <i class="fas fa-download me-2"></i>Télécharger
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.edit', $document->id) --}}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{-- route('documents.destroy', $document->id) --}}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3 text-info"></i>
                                        <p>Aucun rapport disponible</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Onglet Fiches de répartition -->
                        <div class="tab-pane fade" id="repartition" role="tabpanel">
                            <div class="row g-4">
                                @php
                                $repartitions = $documents->filter(function($doc) {
                                return $doc->type === 'Fiche de répartition';
                                });
                                @endphp
                                @if($repartitions->count() > 0)
                                @foreach($repartitions as $document)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="document-icon bg-light rounded-circle p-3 me-3">
                                                    <i class="fas fa-chart-pie text-warning fa-2x"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $document->type }}</h6>
                                                    <small class="text-muted">{{
                                                        \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Ajouté le {{
                                                    \Carbon\Carbon::parse($document->send_at)->format('d/m/Y')
                                                    }}</small>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark p-0" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.download', $document->id) --}}">
                                                                <i class="fas fa-download me-2"></i>Télécharger
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{-- route('documents.edit', $document->id) --}}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{-- route('documents.destroy', $document->id) --}}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12 text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-chart-pie fa-3x mb-3 text-warning"></i>
                                        <p>Aucune fiche de répartition disponible</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection