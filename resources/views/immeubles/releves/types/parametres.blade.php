<div class="section-params row" style="margin: 0.5rem auto;">
    <h4 class="section-title">Paramètres</h4>
    <x-unlock-note shortcut="(" column="paramètres"/>
    
    <div class="row col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="fraisDiv">Frais divers</label>
                <input type="number" class="form-control input_param input-lock" name="fraisDiv" id="fraisDiv" disabled value="{{ $type == 'chauffage' || $type == 'eau' ? ($parametres->FraisDiv ?? 0) : ($parametres->fraisDiv ?? 0) }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="nbFraisTR">Nombre de frais T.R.</label>
                <input type="number" class="form-control input_param input-lock" name="nbFraisTR" id="nbFraisTR" disabled value="{{ $type == 'chauffage' || $type == 'eau' ? ($parametres->NbFraisTR ?? 0) : ($parametres->nbFraisTR ?? 0) }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="pctFraisAnn">Unité des frais annexes</label>
                <input type="number" class="form-control input_param input-lock" name="pctFraisAnn" id="pctFraisAnn" disabled value="{{ $type == 'chauffage' || $type == 'eau' ? ($parametres->PctFraisAnn ?? 0) : ($parametres->pctFraisAnn ?? 0) }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="provision">Montant de provision</label>
                <input type="number" class="form-control input_param input-lock" name="provision" id="provision" disabled value="{{ $parametres->Provision ?? 0 }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="repartProv">Clé de répartition provisions</label>
                <input type="number" class="form-control input_param input-lock" name="repartProv" disabled value="{{ $parametres->RepartProv ?? 0 }}">
            </div>
        </div>

        @if($type == 'chauffage')
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="appQuot">Nombre de quotités</label>
                    <input type="number" class="form-control input_param input-lock" name="appQuot" id="appQuot" disabled value="{{ $parametres->AppQuot ?? 0 }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbRad">Nombre de radiateurs</label>
                    <input type="number" class="form-control input_param input-lock" name="nbRad" id="nbRad" disabled value="{{ $parametres->NbRad ?? 0 }}">
                </div>
            </div>
        @endif

        @if($type == 'eau') 
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbCptEauFroid">Nombre de compteurs eau froide</label>
                    <input type="number" class="form-control input_param input-lock" name="nbCptEauFroid" id="nbCptEauFroid" disabled value="{{ $parametres->NbCptFroid ?? 0 }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbCptEauChaud">Nombre de compteurs eau chaude</label>
                    <input type="number" class="form-control input_param input-lock" name="nbCptEauChaud" id="nbCptEauChaud" disabled value="{{ $parametres->NbCptChaud ?? 0 }}">
                </div>
            </div>
        @endif
        @if($type == 'gaz') 
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbCptGaz">Nombre de compteurs gaz</label>
                    <input type="number" class="form-control input_param input-lock" name="nbCptGaz" id="nbCptGaz" disabled value="{{ $parametres->nbCpt ?? 0 }}">
                </div>
            </div>
        @endif
        @if($type == 'elec') 
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label" for="nbCptElec">Nombre de compteurs électricité</label>
                    <input type="number" class="form-control input_param input-lock" name="nbCptElec" id="nbCptElec" disabled value="{{ $parametres->nbCpt ?? 0 }}">
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    console.log('Script de paramètres chargé');
    
    function toggleInputs(isUnlocked) {
        const inputs = Array.from(document.getElementsByClassName('input_param'));
        console.log('Nombre d\'inputs trouvés:', inputs.length);
        
        inputs.forEach(input => {
            input.disabled = !isUnlocked;
            input.classList.toggle('input-lock', !isUnlocked);
            input.classList.toggle('input-unlock', isUnlocked);
            console.log('Input modifié:', input.name, 'État:', isUnlocked ? 'déverrouillé' : 'verrouillé');
        });
    }

    let isUnlocked = false;
    
    document.addEventListener('keydown', function(e) {
        if (e.key === '(' && !e.repeat) {
            console.log('Touche ( détectée');
            isUnlocked = !isUnlocked;
            toggleInputs(isUnlocked);
        }
    });

    // S'assurer que les inputs sont verrouillés au chargement
    toggleInputs(false);
</script>


