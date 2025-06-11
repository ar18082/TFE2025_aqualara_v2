<div class="section-params row" style="margin: 0.5rem auto;">
    <h4 class="section-title">Paramètres</h4>
    <form id="formParam">
        <div class="row col-md-12">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbFraisTR">Nombre de frais T.R.</label>
                    <input type="number" class="form-control inputParam" name="nbFraisTR" id="nbFraisTR" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="fraisDiv">Frais divers</label>
                    <input type="number" class="form-control inputParam" name="fraisDiv" id="fraisDiv" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="pctFraisAnn">Unité des frais annexes</label>
                    <input type="number" class="form-control inputParam" name="pctFraisAnn" id="pctFraisAnn" disabled>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="provision">Montant de provision</label>
                    <input type="number" class="form-control inputParam" name="provision" id="provision" disabled>
                </div>
            </div>
            <div class="col-md-3 paramEau" style="display: none;">
                <div class=" form-group">
                    <label class="form-label" for="nbFraisTRChaud">Nombre de frais T.R. Chaud</label>
                    <input type="number" class="form-control inputParam" name="nbFraisTRChaud" value="0.00" disabled>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="repartProv">Clé de répartition provisions</label>
                    <input type="number" class="form-control inputParam" name="repartProv" value="0.00" disabled>
                </div>
            </div>

            <!-- Paramètres spécifiques au chauffage -->
            <div class="col-md-3 paramChauff">
                <div class="form-group">
                    <label class="form-label" for="appQuot">Nombre de quotités</label>
                    <input type="number" class="form-control inputParam" name="appQuot" id="appQuot" disabled>
                </div>
            </div>
            <div class="col-md-3 paramChauff">
                <div class="form-group">
                    <label class="form-label" for="nbRad">Nombre de radiateurs</label>
                    <input type="number" class="form-control inputParam" name="nbRad" id="nbRad" disabled>
                </div>
            </div>
            <div class="col-md-3 paramEau" style="display: none;">
                <div class="form-group">
                    <label class="form-label" for="nbCptEauFroid">Nombre de compteurs eau froide</label>
                    <input type="number" class="form-control inputParam" name="nbCptEauFroid" id="nbCptEauFroid" disabled>
                </div>
            </div>
            <div class="col-md-3 paramEau" style="display: none;">
                <div class="form-group">
                    <label class="form-label" for="nbCptEauChaud">Nombre de compteurs eau chaude</label>
                    <input type="number" class="form-control inputParam" name="nbCptEauChaud" id="nbCptEauChaud" disabled>
                </div>
            </div>
            
            <div class="col-md-3 paramGazElec" style="display: none;">
                <div class="form-group">
                    <label class="form-label" for="nbCpt">Nombre de compteurs</label>
                    <input type="number" class="form-control inputParam" name="nbCpt" id="nbCpt" disabled>
                </div>
            </div>
        </div>
    </form>
</div>