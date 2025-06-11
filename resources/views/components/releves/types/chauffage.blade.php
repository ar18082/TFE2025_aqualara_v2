@props(['codeCli', 'refAppTR', 'dateReleve'])

<div x-data="releveChauffage({
    codeCli: '{{ $codeCli }}',
    refAppTR: '{{ $refAppTR }}',
    dateReleve: '{{ $dateReleve }}'
})" 
    x-init="initChauffage"
    @appartement-changed.window="handleAppartementChange($event.detail)"
    @date-changed.window="handleDateChange($event.detail)">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Relevé des radiateurs</h5>
            <x-releves.components.lock-button type="chauffage" />
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Radiateur</th>
                            <th>Pièce</th>
                            <th>Ancien Index</th>
                            <th>Nouvel Index</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="radiateur in radiateurs" :key="radiateur.id">
                            <tr>
                                <td x-text="radiateur.numero"></td>
                                <td x-text="radiateur.piece"></td>
                                <td x-text="radiateur.ancienIndex"></td>
                                <td>
                                    <input type="number" 
                                           class="form-control"
                                           x-model="radiateur.nouvelIndex"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, radiateur)">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" 
                                            @click="showHistory(radiateur)"
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
            <div class="modal fade" id="historyModalChauffage" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Historique des relevés de chauffage</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div x-show="loading">Chargement...</div>
                            <div x-show="!loading">
                                <template x-for="item in history" :key="item.date">
                                    <div class="mb-3">
                                        <strong x-text="item.date"></strong>
                                        <div>Index: <span x-text="item.index"></span></div>
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
    Alpine.data('releveChauffage', ({ codeCli, refAppTR, dateReleve }) => ({
        codeCli,
        refAppTR,
        dateReleve,
        radiateurs: [],
        error: null,
        loading: false,
        history: [],
        isLocked: false,

        async initChauffage() {
            await this.fetchRadiateurs();
            this.initLockState();
        },

        async fetchRadiateurs() {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/chauffage/${this.codeCli}/${this.refAppTR}/${this.dateReleve}`);
                if (!response.ok) throw new Error('Erreur lors du chargement des radiateurs');
                
                const data = await response.json();
                this.radiateurs = data.radiateurs;
                this.error = null;
            } catch (error) {
                this.error = error.message;
                console.error('Erreur:', error);
            } finally {
                this.loading = false;
            }
        },

        initLockState() {
            this.isLocked = window.lockStateStore.isLocked(this.refAppTR, 'chauffage');
        },

        handleAppartementChange({ refAppTR, dateReleve }) {
            this.refAppTR = refAppTR;
            this.dateReleve = dateReleve;
            this.fetchRadiateurs();
        },

        handleDateChange({ dateReleve }) {
            this.dateReleve = dateReleve;
            this.fetchRadiateurs();
        },

        validateIndex(event, radiateur) {
            const newValue = parseFloat(event.target.value);
            const oldValue = parseFloat(radiateur.ancienIndex);

            if (newValue < oldValue) {
                this.error = `Le nouvel index doit être supérieur à l'ancien (${oldValue})`;
                event.target.value = oldValue;
                return;
            }

            this.error = null;
        },

        async showHistory(radiateur) {
            try {
                this.loading = true;
                const response = await fetch(`/api/releves/chauffage/historique/${radiateur.id}`);
                if (!response.ok) throw new Error('Erreur lors du chargement de l\'historique');
                
                const data = await response.json();
                this.history = data.history;
                
                // Afficher le modal
                const modal = new bootstrap.Modal(document.getElementById('historyModalChauffage'));
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