<div class="container-fluid px-4" id="listeDecompte" style='display: none;'>
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('immeubles.decompte.index', $client->Codecli) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <h1 class="text-center mb-0">Liste des décomptes</h1>
                <div style="width: 100px;"></div> <!-- Spacer pour équilibrer le layout -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Codecli</th>
                            <th>Nom</th>
                            <th>Déb. Période</th>
                            <th>Fin Période</th>
                            <th>Nb Rel. Chauffage</th>
                            <th>Nb Rel. Chaud</th>
                            <th>Nb Rel. Froid</th>
                            <th>Nb Rel. Gaz</th>
                            <th>Nb Rel. Élec</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($decomptes as $decompte)
                        <tr>
                            <td>{{ $decompte->Codecli }}</td>
                            <td>{{ $decompte->Nom }}</td>
                            <td>{{ $decompte->DebPer }}</td>
                            <td>{{ $decompte->FinPer }}</td>
                            <td>{{ $decompte->NbRelChauffage }}</td>
                            <td>{{ $decompte->NbRelChaud }}</td>
                            <td>{{ $decompte->NbRelFroid }}</td>
                            <td>{{ $decompte->NbRelGaz }}</td>
                            <td>{{ $decompte->NbRelElec }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" title="Retour">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" title="Clôture">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" title="Suppression">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        white-space: nowrap;
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    .table-responsive {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>