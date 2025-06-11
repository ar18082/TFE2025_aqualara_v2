@props(['codeCli', 'refAppTR', 'dateReleve'])

<div x-data="releveEau({
    codeCli: '{{ $codeCli }}',
    refAppTR: '{{ $refAppTR }}',
    dateReleve: '{{ $dateReleve }}'
})" 
    x-init="initEau"
    @appartement-changed.window="handleAppartementChange($event.detail)"
    @date-changed.window="handleDateChange($event.detail)">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Relevé des compteurs d'eau</h5>
            <x-releves.components.lock-button />
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Compteur</th>
                            <th>Situation</th>
                            <th>Eau Froide Ancien Index</th>
                            <th>Eau Froide Nouvel Index</th>
                            <th>Eau Chaude Ancien Index</th>
                            <th>Eau Chaude Nouvel Index</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="compteur in compteurs" :key="compteur.id">
                            <tr>
                                <td x-text="compteur.numero"></td>
                                <td x-text="compteur.situation"></td>
                                <td x-text="compteur.ancienIndexFroid"></td>
                                <td>
                                    <input type="number" 
                                           class="form-control"
                                           x-model="compteur.nouvelIndexFroid"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, compteur, 'froid')">
                                </td>
                                <td x-text="compteur.ancienIndexChaud"></td>
                                <td>
                                    <input type="number" 
                                           class="form-control"
                                           x-model="compteur.nouvelIndexChaud"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, compteur, 'chaud')">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" 
                                            @click="showHistory(compteur)"
                                            title="Historique">
                                        <i class="fas fa-history"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Message d'erreur -->
            <div x-show="error" class="alert alert-danger mt-3" x-text="error"></div>

            <!-- Historique Modal -->
            <div class="modal fade" id="historyModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Historique des relevés</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div x-show="loading">Chargement...</div>
                            <div x-show="!loading">
                                <template x-for="item in history" :key="item.date">
                                    <div class="mb-3">
                                        <strong x-text="item.date"></strong>
                                        <div>Eau Froide: <span x-text="item.indexFroid"></span></div>
                                        <div>Eau Chaude: <span x-text="item.indexChaud"></span></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('releveEau', ({ codeCli, refAppTR, dateReleve }) => ({
        codeCli,
        refAppTR,
        dateReleve,
        compteurs: [],
        error: null,
        loading: false,
        history: [],
        isLocked: false,

        async initEau() {
            await this.fetchCompteurs();
            this.initLockState();
        },

        async fetchCompteurs() {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/eau/${this.codeCli}/${this.refAppTR}/${this.dateReleve}`);
                if (!response.ok) throw new Error('Erreur lors du chargement des compteurs');
                
                const data = await response.json();
                this.compteurs = data.compteurs;
                this.error = null;
            } catch (error) {
                this.error = error.message;
                console.error('Erreur:', error);
            } finally {
                this.loading = false;
            }
        },

        initLockState() {
            // Initialisation du state de verrouillage depuis le store
            this.isLocked = window.lockStateStore.isLocked(this.refAppTR, 'eau');
        },

        handleAppartementChange({ refAppTR, dateReleve }) {
            this.refAppTR = refAppTR;
            this.dateReleve = dateReleve;
            this.fetchCompteurs();
        },

        handleDateChange({ dateReleve }) {
            this.dateReleve = dateReleve;
            this.fetchCompteurs();
        },

        validateIndex(event, compteur, type) {
            const newValue = parseFloat(event.target.value);
            const oldValue = type === 'froid' ? 
                parseFloat(compteur.ancienIndexFroid) : 
                parseFloat(compteur.ancienIndexChaud);

            if (newValue < oldValue) {
                this.error = `Le nouvel index doit être supérieur à l'ancien (${oldValue})`;
                event.target.value = oldValue;
                return;
            }

            this.error = null;
        },

        async showHistory(compteur) {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/eau/historique/${compteur.id}`);
                if (!response.ok) throw new Error('Erreur lors du chargement de l\'historique');
                
                const data = await response.json();
                this.history = data.history;
                
                // Afficher le modal
                const modal = new bootstrap.Modal(document.getElementById('historyModal'));
                modal.show();
            } catch (error) {
                this.error = error.message;
                console.error('Erreur:', error);
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>
@endpush 