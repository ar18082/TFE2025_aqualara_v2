<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h4 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Clôture des Décomptes</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 50px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th scope="col">SDC client</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Deb. Per. </th>
                        <th scope="col">Fin. Per.</th>
                        <th scope="col">Nb. Rel Chauffage</th>
                        <th scope="col">Nb. Rel Eau Chaude</th>
                        <th scope="col">Nb. Rel Eau Froide</th>
                        <th scope="col">Nb. Rel Gaz</th>
                        <th scope="col">Nb. Rel Elec</th>

                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($decomptes as $decompte)
                    <tr>
                        <td class="text-center">
                            <div class="form-check">
                                <input class="form-check-input decompte-checkbox" type="checkbox"
                                    value="{{ $decompte->id }}" name="decomptes[]">
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold">{{ str_pad($decompte->Codecli, 5, '0', STR_PAD_LEFT)}}</span>
                        </td>
                        <td>
                            <span class="fw-semibold">{{$client->nom }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-muted small"> {{
                                    \Carbon\Carbon::parse($decompte->debPer)->format('d/m/Y') }}</span>

                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">

                                <span class="text-muted small">{{
                                    \Carbon\Carbon::parse($decompte->finPer)->format('d/m/Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <span>{{$decompte->chfNbQuot }}</span>
                        </td>
                        <td>
                            <span>{{ $decompte->eauNbQuot }}</span>
                        </td>
                        <td>
                            <span>{{ $decompte->eauNbQuot }}</span>
                        </td>
                        <td>
                            <span>{{ $decompte->gazNbQuot }}</span>
                        </td>
                        <td>
                            <span>{{ $decompte->elecNbQuot }}</span>
                        </td>

                        <td class="text-end">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                    title="Voir le détail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                    title="Clôturer">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-2x mb-3"></i>
                                <p class="mb-0">Aucun décompte disponible</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($decomptes->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">

                <button type="button" class="btn btn-primary" id="clotureSelected">
                    <i class="fas fa-check-circle me-2"></i>Clôturer les décomptes sélectionnés
                </button>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('immeubles.decompte.index', $client->Codecli) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
            <div>

                {{ $decomptes->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    .btn-group .btn i {
        font-size: 0.875rem;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #0d6efd;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Gestion de la sélection multiple
        const selectAllCheckbox = document.getElementById('selectAll');
        const decompteCheckboxes = document.querySelectorAll('.decompte-checkbox');
        const clotureSelectedBtn = document.getElementById('clotureSelected');

        selectAllCheckbox.addEventListener('change', function() {
            decompteCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateClotureButtonState();
        });

        decompteCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateClotureButtonState();
            });
        });

        function updateClotureButtonState() {
            const checkedCount = document.querySelectorAll('.decompte-checkbox:checked').length;
            clotureSelectedBtn.disabled = checkedCount === 0;
        }

        // Gestion de la clôture des décomptes sélectionnés
        clotureSelectedBtn.addEventListener('click', function() {
            const selectedDecomptes = Array.from(document.querySelectorAll('.decompte-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedDecomptes.length > 0) {
                Swal.fire({
                    title: 'Confirmation',
                    text: `Voulez-vous clôturer ${selectedDecomptes.length} décompte(s) ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, clôturer',
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#0d6efd'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Ajouter la logique de clôture des décomptes
                        Swal.fire({
                            title: 'Succès',
                            text: 'Les décomptes ont été clôturés avec succès',
                            icon: 'success',
                            confirmButtonColor: '#0d6efd'
                        });
                    }
                });
            }
        });
    });
</script>