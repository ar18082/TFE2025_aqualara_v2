<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h4 class="mb-0"><i class="fas fa-calculator me-2"></i>Préparation du Décompte</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('immeubles.decompte.storePreparation', $client->Codecli) }}"
            class="row g-4" id="preparationForm">
            @csrf
            <!-- Période de calcul -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Période de calcul</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateDebut" class="form-label">Date début</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" id="dateDebut" name="dateDebut" required
                                            value="{{ date('Y-m-d', strtotime($decompteProvisoire->date_debut)) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateFin" class="form-label">Date fin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" id="dateFin" name="dateFin" required
                                            value="{{ date('Y-m-d', strtotime($decompteProvisoire->date_fin)) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Type de calcul -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Type de calcul</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check custom-checkbox mb-3">
                            <input class="form-check-input" type="radio" id="complet" name="typeCalcul" value="complet">
                            <label class="form-check-label" for="complet">
                                <i class="fas fa-check-circle me-2"></i>Complet
                            </label>
                        </div>
                        <div class="form-check custom-checkbox mb-3">
                            <input class="form-check-input" type="radio" id="individuel" name="typeCalcul"
                                value="individuel">
                            <label class="form-check-label" for="individuel">
                                <i class="fas fa-user me-2"></i>Individuel
                            </label>
                        </div>
                        <div class="form-check custom-checkbox">
                            <input class="form-check-input" type="radio" id="gerance" name="typeCalcul" value="gerance">
                            <label class="form-check-label" for="gerance">
                                <i class="fas fa-building me-2"></i>Gérance
                            </label>
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- Bouton de soumission -->
            <div class="col-12 text-center mt-4">
                <a href="{{ route('immeubles.decompte.index', $client->Codecli) }}"
                    class="btn btn-secondary btn-lg px-5 me-3">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                    <i class="fas fa-calculator me-2"></i>Calculer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour la sélection des appartements -->
<div class="modal fade" id="appartementsModal" tabindex="-1" aria-labelledby="appartementsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="appartementsModalLabel">
                    <i class="fas fa-building me-2"></i>Sélection des appartements
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <select multiple class="form-select" id="appartementsList" name="appartements[]" size="10">
                        @foreach ($appartements as $appartement)
                            <option value="{{$appartement->id}}">
                                {{$appartement->RefAppTR}} - {{$appartement->RefAppCli}} - {{$appartement->proprietaire}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAppartements">Confirmer</button>
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

    .card-header h5 {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
    }

    .custom-checkbox .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
    }

    .custom-checkbox .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .custom-checkbox .form-check-label {
        font-size: 1.1em;
        padding-left: 0.5em;
        cursor: pointer;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }

    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-primary {
        background-color: #023c7b;
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.65;
        transform: none !important;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('preparationForm');
        const submitBtn = document.getElementById('submitBtn');
        const dateDebut = document.getElementById('dateDebut');
        const dateFin = document.getElementById('dateFin');
        const individuelRadio = document.getElementById('individuel');
        
        // Initialiser la modal de manière sécurisée
        let appartementsModal;
        try {
            // Vérifier si Bootstrap est disponible
            if (typeof bootstrap !== 'undefined') {
                appartementsModal = new bootstrap.Modal(document.getElementById('appartementsModal'));
            } else {
                console.error('Bootstrap n\'est pas chargé. Veuillez inclure le fichier JavaScript de Bootstrap.');
                // Fallback: utiliser une approche alternative pour afficher/masquer la modal
                const modalElement = document.getElementById('appartementsModal');
                if (modalElement) {
                    // Méthode alternative pour afficher/masquer la modal
                    const showModal = () => {
                        modalElement.style.display = 'block';
                        modalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    };
                    
                    const hideModal = () => {
                        modalElement.style.display = 'none';
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    };
                    
                    // Ajouter des gestionnaires d'événements pour les boutons de fermeture
                    const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
                    closeButtons.forEach(button => {
                        button.addEventListener('click', hideModal);
                    });
                    
                    // Exposer les méthodes show/hide
                    appartementsModal = {
                        show: showModal,
                        hide: hideModal
                    };
                }
            }
        } catch (error) {
            console.error('Erreur lors de l\'initialisation de la modal:', error);
        }
        
        const selectAllAppartements = document.getElementById('selectAllAppartements');
        const appartementCheckboxes = document.querySelectorAll('.appartement-checkbox');
        const confirmAppartementsBtn = document.getElementById('confirmAppartements');
        const searchAppartement = document.getElementById('searchAppartement');

        // Afficher la modal lors de la sélection de l'option Individuel
        individuelRadio.addEventListener('click', function() {
            if (this.checked && appartementsModal) {
                appartementsModal.show();
            }
        });
        
        // Sélectionner/désélectionner tous les appartements
        selectAllAppartements.addEventListener('change', function() {
            appartementCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        // Recherche d'appartements
        searchAppartement.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#appartementsList tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Confirmer la sélection des appartements
        confirmAppartementsBtn.addEventListener('click', function() {
            const selectedAppartements = document.querySelectorAll('.appartement-checkbox:checked');
            if (selectedAppartements.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Attention',
                    text: 'Veuillez sélectionner au moins un appartement'
                });
                return;
            }
            
            // Stocker les IDs des appartements sélectionnés dans un champ caché
            const selectedIds = Array.from(selectedAppartements).map(checkbox => checkbox.value);
            
            // Créer ou mettre à jour le champ caché
            let hiddenInput = document.getElementById('selectedAppartements');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'selectedAppartements';
                hiddenInput.name = 'selectedAppartements';
                form.appendChild(hiddenInput);
            }
            hiddenInput.value = JSON.stringify(selectedIds);
            
            // Fermer la modal
            appartementsModal.hide();
            
            // Afficher un message de confirmation
            Swal.fire({
                icon: 'success',
                title: 'Appartements sélectionnés',
                text: `${selectedAppartements.length} appartement(s) sélectionné(s)`,
                showConfirmButton: false,
                timer: 1500
            });
        });
        
        // Validation des dates
        dateFin.addEventListener('change', function() {
            if (dateDebut.value && this.value < dateDebut.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'La date de fin ne peut pas être antérieure à la date de début'
                });
                this.value = '';
            }
        });
        
        dateDebut.addEventListener('change', function() {
            if (dateFin.value && dateFin.value < this.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'La date de fin ne peut pas être antérieure à la date de début'
                });
                dateFin.value = '';
            }
        });

        // Gestion de la soumission du formulaire
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Vérifier si un type de calcul est sélectionné
            const typeCalculSelected = document.querySelector('input[name="typeCalcul"]:checked');
            if (!typeCalculSelected) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Attention',
                    text: 'Veuillez sélectionner un type de calcul'
                });
                return;
            }
            
            // Si le type de calcul est Individuel, vérifier que des appartements ont été sélectionnés
            if (typeCalculSelected.value === 'individuel') {
                const selectedAppartements = document.getElementById('selectedAppartements');
                if (!selectedAppartements || !selectedAppartements.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention',
                        text: 'Veuillez sélectionner au moins un appartement'
                    });
                    return;
                }
            }

            // Désactiver le bouton pendant la soumission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Calcul en cours...';

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // TODO: Ajouter votre logique de redirection ou de mise à jour de l'interface ici
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message || 'Une erreur est survenue'
                    });
                }
            } catch (error) {
                console.error('Erreur:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de la préparation du décompte'
                });
            } finally {
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-calculator me-2"></i>Calculer';
            }
        });
    });
</script>