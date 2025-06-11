@if($clichauf)
<div id="detailChauff" class="detail-section">
    <form action="{{route('immeubles.donneeGeneraleUpdate', ['codecli' => $client->Codecli, 'type' => 'chauff'])}}"
        method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$clichauf->id}}">

        <div class="section-header">
            <div class="section-title-container">
                <h2 class="section-title">Données Générales</h2>
                <small class="text-muted">
                    <i class="fa-regular fa-circle-info me-1"></i>
                    Appuyez sur la touche § pour déverrouiller/verrouiller les champs du formulaire
                </small>
            </div>

            <div class="btn-group">
                <button type="button" id="btn_edit" class="btn-edit">
                    <i class="fa fa-pen me-1"></i>Modifier
                </button>
                <button type="submit" id="btn_save" class="btn-save" style="display: none;">
                    <i class="fa fa-save me-1"></i>Enregistrer
                </button>
            </div>
        </div>

        <div class="radio-group">
            <div class="form-check">
                <input class="form-check-input inputChauffage" type="radio" name="pourcentage" id="pourcentage"
                    disabled>
                <label class="form-check-label" for="pourcentage">Sur pourcentage</label>
            </div>
            <div class="form-check">
                <input class="form-check-input inputChauffage" type="radio" name="montant" id="montant" disabled>
                <label class="form-check-label" for="montant">Sur montant</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="percentage-section">
                    <div class="section-header">
                        <h5>Pourcentages</h5>
                    </div>
                    <div class="form-group">
                        <label for="PctPrive">Pourcentage Privé</label>
                        <input type="text" id="PctPrive" name="PctPrive" class="form-control inputChauffage"
                            value="{{$clichauf->PctPrive?? ''}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="PctCom">Pourcentage Commun</label>
                        <input type="text" id="PctCom" name="PctCom" class="form-control inputChauffage"
                            value="{{$clichauf->PctCom ?? ''}}" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="amount-section">
                    <div class="section-header">
                        <h5>Montants</h5>
                    </div>
                    <div class="form-group">
                        <label for="consommationPrive">Montant privé</label>
                        <input type="text" id="consommationPrive" name="consommationPrive"
                            class="form-control inputChauffage"
                            value="{{$clichauf->ConsPrive ?? number_format(($clichauf->Consom / 100) *  $clichauf->PctPrive, 2)}}"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="consommationCommun">Montant commun</label>
                        <input type="text" id="consommationCommun" name="consommationCommun"
                            class="form-control inputChauffage"
                            value="{{$clichauf->ConsCom ?? number_format( ($clichauf->Consom /100) * $clichauf->PctCom,2)}}"
                            disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="quotite">Quotité</label>
                    <input type="text" id="quotite" name="quotite" class="form-control inputChauffage"
                        value="{{$clichauf->Quotite != null ? $clichauf->Quotite : '0' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="typeCalo">Type de Calorimètres</label>
                    <select id="typeCalo" name="typeCalo" class="form-control inputChauffage" disabled>
                        <option value="RFC EV" {{$clichauf->TypCal == "RFC EV" ? 'selected' : ''}}>RFC EV</option>
                        <option value="ELECT" {{$clichauf->TypCal == "ELECT" ? 'selected' : ''}}>ELECT</option>
                        <option value="CPT INT" {{$clichauf->TypCal == "CPT INT" ? 'selected' : ''}}>CPT INT</option>
                        <option value="CALO" {{$clichauf->TypCal == "CALO" ? 'selected' : ''}}>CALO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="TypRlv">Type de relevé</label>
                    <select id="TypRlv" name="TypRlv" class="form-control inputChauffage" disabled>
                        <option value="VISU" {{$clichauf->TypRlv == "VISU" ? 'selected' : ''}}>VISU</option>
                        <option value="GPRS" {{$clichauf->TypRlv == "GPRS" ? 'selected' : ''}}>GPRS</option>
                        <option value="RADIO" {{$clichauf->TypRlv == "RADIO" ? 'selected' : ''}}>RADIO</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="section-header mt-4">
            <div class="section-title-container">
                <h2 class="section-title">Données des relevés</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Consom">Consommation</label>
                    <input type="text" id="Consom" name="Consom" class="form-control inputChauffage"
                        value="{{$clichauf->Consom}}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="FraisAnn">Total des frais annexes</label>
                    <input type="text" id="FraisAnn" name="FraisAnn" class="form-control inputChauffage"
                        value="{{$clichauf->FraisAnn}}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="UniteAnn">Nombre d'unités pour le calcul des frais annexes</label>
                    <input type="text" id="UniteAnn" name="UniteAnn" class="form-control inputChauffage"
                        value="{{$clichauf->UniteAnn}}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="libFrAnn">Libellé frais annexes</label>
                    <input type="text" id="libFrAnn" name="libFrAnn" class="form-control inputChauffage" value=""
                        disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="FraisTR">Frais T.R.</label>
                    <input type="text" id="FraisTR" name="FraisTR" class="form-control inputChauffage"
                        value="{{number_format($clichauf->FraisTR,4)}}" disabled>
                </div>
            </div>
        </div>

        <input type="hidden" name="donneeGenerale" value="chauff">
    </form>
</div>
@else
<div class="alert alert-danger" role="alert">
    <i class="fa-regular fa-circle-exclamation me-2"></i>
    Aucune donnée générale pour le chauffage
</div>
@endif

@if(isset($error))
<div class="alert alert-info" role="alert">
    <i class="fa-regular fa-circle-info me-2"></i>
    {{ $error }}
</div>
@endif