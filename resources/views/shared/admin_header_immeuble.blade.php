<div class="card mb-2 shadow-sm">
    <div class="card-header bg-primary text-white py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fa-regular fa-building me-2"></i>
                <h5 class="mb-0">{{ str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom }}</h5>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs nav-fill border-bottom">
        <li class="nav-item">
            <a href="{{ route('immeubles.appartements', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.appartements') ? 'active' : '' }}">
                <i class="fa-regular fa-door-open me-1"></i>Appartement
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('immeubles.details', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.details') ? 'active' : '' }}">
                <i class="fa-regular fa-info-circle me-1"></i>Détail
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('immeubles.documents', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.documents') ? 'active' : '' }}">
                <i class="fa-regular fa-file-lines me-1"></i>Documents
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('immeubles.factures', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.factures') ? 'active' : '' }}">
                <i class="fa-regular fa-receipt me-1"></i>Factures
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('immeubles.interventions', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.interventions') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar me-1"></i>Interventions
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('immeubles.saisie', $client->Codecli) }}"
                class="nav-link {{ request()->routeIs('immeubles.saisie') ? 'active' : '' }}">
                <i class="fa-regular fa-keyboard me-1"></i>Saisie
            </a>
        </li>
        <li class="nav-item ms-auto">
            <a href="{{ route('immeubles.decompte.index', $client->Codecli) }}" class="nav-link text-success">
                <i class="fa-regular fa-file-invoice-dollar me-1"></i>Générer décompte
            </a>
        </li>
    </ul>

    <div class="card-body bg-light py-2">
        <div class="row g-2">
            <div class="col-md-3">
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fa-regular fa-box-open-full text-primary"></i>
                    </div>
                    <div class="content">
                        <div class="title">{{ $client->gerantImms->get(0)->codegerant }}</div>
                        <div class="subtitle">{{ $client->gerant }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fa-duotone fa-map-location-dot text-primary"></i>
                    </div>
                    <div class="content">
                        <div class="title">{{ $client->rue }}</div>
                        <div class="subtitle">{{ $client->codepost }} {{ $client->codePostelbs->get(0)->Localite }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-card">
                    <div class="icon-wrapper">
                        @php
                        $chauType = $client->clichaufs->get(0);
                        $eauType = $client->cliEaus->get(0);
                        if (isset($chauType->TypRlv) && $chauType->TypRlv == 'VISU') {
                        $chauIcon = 'eye';
                        } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'GPRS') {
                        $chauIcon = 'wifi';
                        } elseif (isset($chauType->TypRlv) && $chauType->TypRlv == 'RADIO') {
                        $chauIcon = 'walkie-talkie';
                        } else {
                        $chauIcon = '';
                        }

                        if (isset($eauType->TypRlv) && $eauType->TypRlv == 'VISU') {
                        $eauIcon = 'eye';
                        } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'GPRS') {
                        $eauIcon = 'wifi';
                        } elseif (isset($eauType->TypRlv) && $eauType->TypRlv == 'RADIO') {
                        $eauIcon = 'walkie-talkie';
                        } else {
                        $eauIcon = '';
                        }
                        @endphp
                        @if($chauIcon != '')
                        <div class="status-indicator warning">
                            <i class="fa-regular fa-{{ $chauIcon }}"></i>
                        </div>
                        @endif
                        @if($eauIcon != '')
                        <div class="status-indicator info mt-2">
                            <i class="fa-regular fa-{{ $eauIcon }}"></i>
                        </div>
                        @endif
                    </div>
                    <div class="content">
                        <div class="title">Type de relevé</div>
                        <div class="subtitle">
                            @if(isset($releveTypes) && is_array($releveTypes) && count($releveTypes) > 0)
                            <div class="releve-types">
                                @foreach($releveTypes as $releve)
                                <div class="releve-type-item">
                                    <i class="fa-regular {{ $releve['icon'] }}"></i>
                                    <span>{{ $releve['label'] }}: {{ $releve['type'] }}</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            Aucun type de relevé configuré
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                @if($nbImmAbsent > 0)
                <div class="info-card">
                    <div class="icon-wrapper">
                        <i class="fa-regular fa-user-slash text-danger"></i>
                    </div>
                    <div class="content">
                        <div class="title text-danger">Absents</div>
                        <div class="badge bg-danger">{{ $nbImmAbsent }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>