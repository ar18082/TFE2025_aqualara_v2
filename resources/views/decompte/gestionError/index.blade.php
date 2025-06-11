@extends('base')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestion des Erreurs</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type d'erreur</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Erreur de validation</td>
                            <td>Le champ montant doit être un nombre</td>
                            <td>2024-03-20 14:30</td>
                            <td>
                                <span class="badge bg-warning">En attente</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="forceError1">
                                        <label class="form-check-label" for="forceError1">
                                            Forcer
                                        </label>
                                    </div>
                                    <a href="{{--route('decompte.gestion-error.show', 1)--}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.85em;
    }
    .form-check {
        margin-right: 10px;
    }
</style>
@endpush
@endsection
