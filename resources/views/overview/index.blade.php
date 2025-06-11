@extends('base')

@section('title', 'Immeubles - Liste')

@section('content')
    <div class="container-xxxl">
        <div class="row">
            <div class="col-12 my-3">
                <h1 class="text-primary border-bottom border-1 border-tertiary fs-2">Aquatel: Accueil</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="p-3 border border-1 rounded" style="background-color: white">
                    <h2 class="text-primary border-bottom border-1 border-tertiary fs-4 w-50">Clients</h2>

                    <div class="list-group bg-dark-subtle">
                        <a href="" class="list-group-item list-group-item-action" aria-current="true">
                            Liste des clients
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Créer un client</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border border-1 rounded" style="background-color: white">
                    <h2 class="text-primary border-bottom border-1 border-tertiary fs-4 w-50">Planning</h2>

                    <div class="list-group bg-dark-subtle">
                        <a href="" class="list-group-item list-group-item-action" aria-current="true">
                            Evenements
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Calendrier</a>
                        <a href="#" class="list-group-item list-group-item-action">Cartographie</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border border-1 rounded" style="background-color: white">
                    <h2 class="text-primary border-bottom border-1 border-tertiary fs-4 w-50">Décompte</h2>

                    <div class="list-group bg-dark-subtle">
                        <a href="" class="list-group-item list-group-item-action" aria-current="true">
                            Saisie
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Historique</a>

                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="p-3 border border-1 rounded" style="background-color: white">
                    <h2 class="text-primary border-bottom border-1 border-tertiary fs-4 w-50">Facturations</h2>

                    <div class="list-group bg-dark-subtle">
                        <a href="" class="list-group-item list-group-item-action" aria-current="true">
                            Saisie
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">historique</a>

                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="p-3 border border-1 rounded" style="background-color: white">
                    <h2 class="text-primary border-bottom border-1 border-tertiary fs-4 w-50">Documents</h2>

                    <div class="list-group bg-dark-subtle">
                        <a href="" class="list-group-item list-group-item-action" aria-current="true">
                            Bon de route
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Avis de passage</a>
                        <a href="#" class="list-group-item list-group-item-action">Feuille de frais</a>
                        <a href="#" class="list-group-item list-group-item-action">Rapport</a>
                        <a href="#" class="list-group-item list-group-item-action">Décompte</a>


                    </div>
                </div>
            </div>

        </div>
@endsection
