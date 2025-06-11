<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-danger text-white py-4">
                    <h3 class="mb-0 text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>Impossible de préparer le décompte
                    </h3>
                </div>
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-check fa-4x text-danger"></i>
                    </div>
                    <h4 class="mb-3">Aucune saisie validée</h4>
                    <p class="text-muted mb-4">
                        Il est impossible de préparer ce décompte car aucune saisie n'a été validée pour cette période.
                        Veuillez d'abord effectuer et valider les saisies nécessaires avant de tenter de préparer un
                        décompte.
                    </p>
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Conseil :</strong> Vérifiez que toutes les saisies (chauffage, eau, gaz, électricité)
                        ont été correctement effectuées et validées.
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('immeubles.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste des immeubles
                        </a>
                        <a href="{{ route('immeubles.saisie', $client->Codecli) }}" class="btn btn-primary">
                            <i class="fas fa-clipboard-list me-2"></i>Accéder aux saisies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .fa-clipboard-check {
        color: #dc3545;
    }

    .btn {
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .btn-primary {
        background-color: #023c7b;
        border-color: #023c7b;
    }

    .btn-primary:hover {
        background-color: #032a5a;
        border-color: #032a5a;
    }

    .alert-info {
        background-color: #e8f4fd;
        border-color: #bee5eb;
        color: #0c5460;
    }
</style>