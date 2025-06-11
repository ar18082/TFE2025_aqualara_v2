<div class="releve-chauffage">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Relevé Chauffage</h5>
           
        </div>

        <div class="card-body">
            <!-- Paramètres -->
            <div class="parameters mb-4" x-show="parameters">
                <h6>Paramètres</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nombre de radiateurs</label>
                            <input type="number" 
                                   class="form-control" 
                                   x-model="parameters.NbRad"
                                   :disabled="isLocked">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Frais divers</label>
                            <input type="number" 
                                   class="form-control" 
                                   x-model="parameters.FraisDiv"
                                   :disabled="isLocked">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>% Frais annuels</label>
                            <input type="number" 
                                   class="form-control" 
                                   x-model="parameters.PctFraisAnn"
                                   :disabled="isLocked">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Quotient</label>
                            <input type="number" 
                                   class="form-control" 
                                   x-model="parameters.AppQuot"
                                   :disabled="isLocked">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table des relevés -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Radiateur</th>
                            <th>N° Calculateur</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Situation</th>
                            <th>Coefficient</th>
                            <th>Ancien Index</th>
                            <th>Nouvel Index</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(rad, index) in radiateurs" :key="index">
                            <tr>
                                <td x-text="rad.NumRad"></td>
                                <td>
                                    <input type="text" 
                                           class="form-control" 
                                           x-model="rad.NumCal"
                                           :disabled="isLocked">
                                </td>
                                <td>
                                    <select class="form-select" 
                                            x-model="rad.TypCal"
                                            :disabled="isLocked">
                                        <option value="E">Électronique</option>
                                        <option value="M">Mécanique</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" 
                                            x-model="rad.Statut"
                                            :disabled="isLocked">
                                        <option value="OK">OK</option>
                                        <option value="HS">Hors Service</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" 
                                           class="form-control" 
                                           x-model="rad.Sit"
                                           :disabled="isLocked">
                                </td>
                                <td>
                                    <input type="number" 
                                           class="form-control" 
                                           x-model="rad.Coef"
                                           :disabled="isLocked">
                                </td>
                                <td>
                                    <input type="number" 
                                           class="form-control" 
                                           x-model="rad.AncIdx"
                                           :disabled="isLocked">
                                </td>
                                <td>
                                    <input type="number" 
                                           class="form-control" 
                                           x-model="rad.NvIdx"
                                           :disabled="isLocked"
                                           @input="validateIndex($event, index)">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Boutons d'action -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-secondary me-2" 
                        @click="resetForm"
                        :disabled="isLocked">
                    Réinitialiser
                </button>
                <button class="btn btn-primary" 
                        @click="saveReleve"
                        :disabled="isLocked || !isValid">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.releve-chauffage input[disabled],
.releve-chauffage select[disabled] {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.releve-chauffage .form-control,
.releve-chauffage .form-select {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}

.releve-chauffage .table td {
    vertical-align: middle;
}
</style>
@endpush 