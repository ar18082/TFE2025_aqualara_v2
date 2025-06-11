@props(['codeCli', 'refAppTR', 'dateReleve'])

<div x-data="releveElec({
    codeCli: '{{ $codeCli }}',
    refAppTR: '{{ $refAppTR }}',
    dateReleve: '{{ $dateReleve }}'
})" 
    x-init="initElec"
    @appartement-changed.window="handleAppartementChange($event.detail)"
    @date-changed.window="handleDateChange($event.detail)">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Relevé des compteurs électriques</h5>
            <x-releves.components.lock-button type="elec" />
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Compteur</th>
                            <th>Situation</th>
                            <th>HP Ancien Index</th>
                            <th>HP Nouvel Index</th>
                            <th>HC Ancien Index</th>
                            <th>HC Nouvel Index</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="compteur in compteurs" :key="compteur.id">
                            <tr>
                                <td x-text="compteur.numero"></td>
                                <td x-text="compteur.situation"></td>
                                <td x-text="compteur.ancienIndexHP"></td>
                                <td>
                                    <input type="number" 
                                           class="form-control"
                                           x-model="compteur.nouvelIndexHP"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, compteur, 'HP')">
                                </td>
                                <td x-text="compteur.ancienIndexHC"></td>
                                <td>
                                    <input type="number" 
                                           class="form-control"
                                           x-model="compteur.nouvelIndexHC"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, compteur, 'HC')">
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
            <div class="modal fade" id="historyModalElec" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Historique des relevés électriques</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div x-show="loading">Chargement...</div>
                            <div x-show="!loading">
                                <template x-for="item in history" :key="item.date">
                                    <div class="mb-3">
                                        <strong x-text="item.date"></strong>
                                        <div>HP: <span x-text="item.indexHP"></span></div>
                                        <div>HC: <span x-text="item.indexHC"></span></div>
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
    Alpine.data('releveElec', ({ codeCli, refAppTR, dateReleve }) => ({
        codeCli,
        refAppTR,
        dateReleve,
        compteurs: [],
        error: null,
        loading: false,
        history: [],
        isLocked: false,

        async initElec() {
            await this.fetchCompteurs();
            this.initLockState();
        },

        async fetchCompteurs() {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/elec/${this.codeCli}/${this.refAppTR}/${this.dateReleve}`);
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
            this.isLocked = window.lockStateStore.isLocked(this.refAppTR, 'elec');
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
            const oldValue = type === 'HP' ? 
                parseFloat(compteur.ancienIndexHP) : 
                parseFloat(compteur.ancienIndexHC);

            if (newValue < oldValue) {
                this.error = `Le nouvel index ${type} doit être supérieur à l'ancien (${oldValue})`;
                event.target.value = oldValue;
                return;
            }

            this.error = null;
        },

        async showHistory(compteur) {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/elec/historique/${compteur.id}`);
                if (!response.ok) throw new Error('Erreur lors du chargement de l\'historique');
                
                const data = await response.json();
                this.history = data.history;
                
                // Afficher le modal
                const modal = new bootstrap.Modal(document.getElementById('historyModalElec'));
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