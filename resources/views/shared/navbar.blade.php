<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary" >
    <div class="container-fluid">
        <a class="navbar-brand bg-light px-2" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Aquatel" height="28" width="106"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                 @if(Auth::check() && Auth::user()->role === 'admin' || Auth::user()->role === 'bureau' )
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('immeubles.*') ? 'active' : '' }}" href="{{ route('immeubles.index') }}" @if(request()->routeIs('immeubles.*')) aria-current="page" @endif  >Immeubles</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Planning
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.event.index') }}">Evenements</a></li>
                        <li> <a  class="dropdown-item" href="{{route('calendar.index')}}">Calendrier</a></li>
                        <li> <a  class="dropdown-item" href="{{route('cartography.index')}}">Cartographie</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Documents
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('documents.listeDocument', ['type' => 'Bon']) }}">Bons de route</a></li>
                        <li><a class="dropdown-item" href="{{ route('documents.listeDocument', ['type' => 'Avis']) }}">Avis de passage</a></li>
                        <li><a class="dropdown-item" href="{{ route('documents.listeDocument', ['type' => 'Rapport']) }}">Rapports</a></li>
                        <li><a class="dropdown-item" href="{{ route('documents.listeSDC') }}">Liste SDC</a></li>


                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        E-mail
                    </a>
                    <div class="dropdown-menu">
                        @include('emails.form')
                    </div>
                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Décompte
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('documents.showFeuilleFrais')}}">Feuille de frais</a></li>
                    </ul>
                </li> --}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                        Facturation--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a class="dropdown-item" href="{{ route('facturation.index') }}">Triage</a></li>--}}
{{--                        <li><a class="dropdown-item" href="{{ route('facturation.listeFactures') }}">Liste factures </a></li>--}}

{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                        Centrale--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a class="dropdown-item" href="#--}}{{--route('centrales.index')--}}{{--">Liste</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Nouvelle centrale</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Liste erreurs</a></li>--}}

{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                        XML--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a class="dropdown-item" href="{{route('testParser')}}">test parser</a></li>--}}
{{--                        <li><a class="dropdown-item" href="{{route('generateXmlFile')}}">test Generate</a></li>--}}


{{--                    </ul>--}}
{{--                </li>--}}
                @if(Auth::user()->role === 'admin' )
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.appareil.index') }}">Appareils</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.materiel.index') }}">Materiel</a></li>
                        <li><a class="dropdown-item" href="{{ route('appartementMateriel.index') }}">Appartement_Materiel</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.contact.index') }}">Contacts</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.file_storage.index') }}">File Storage</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.technicien.index') }}">Techniciens</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.user.index') }}">User</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.avisPassageText.index') }}">textes avis de passage</a></li>
                        <li><a class="dropdown-item" href="{{ route('mailContents.index') }}">Modèle E-mail</a></li>




                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.quickregen') }}">Quick Regen</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Type
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.statusTechnicien.index') }}">Status Technicien</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.typeEvent.index') }}" >Type Event</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.typeErreur.index') }}">Type erreurs</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.couleurTechnicien.index') }}">Couleur</a></li>

                    </ul>
                </li>
                @endif
            </ul>
            @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('immeubles.*') ? 'active' : '' }}" href="{{ route('immeubles.index') }}" @if(request()->routeIs('immeubles.*')) aria-current="page" @endif  >Immeubles</a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="{{route('calendar.index')}}">Planning</a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="{{route('cartography.cartographyTechnicien')}}">Cartographie</a>
                </li>
            @endif
            <div>
                <div class="nav-item dropdown">
                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</a>
                            </form>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</nav>
