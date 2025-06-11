@if($cliEaus && $cliEaus->count() > 0)
@php
$cliEau = $cliEaus->first();
@endphp
<div id="detailEau" class="detail-section">
    <form action="{{route('immeubles.donneeGeneraleUpdate', ['codecli' => $client->Codecli, 'type' => 'eau'])}}"
        method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$cliEau->id}}">

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

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="quotite">Quotité</label>
                    <input type="text" id="quotite" name="quotite" class="form-control inputEau"
                        value="{{$cliEau->Quotite != null ? $cliEau->Quotite : '0' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="typeCompteur">Type de Compteur</label>
                    <select id="typeCompteur" name="typeCompteur" class="form-control inputEau" disabled>
                        <option value="STANDARD" {{$cliEau->TypCompt == "STANDARD" ? 'selected' : ''}}>STANDARD</option>
                        <option value="PRECIS" {{$cliEau->TypCompt == "PRECIS" ? 'selected' : ''}}>PRECIS</option>
                        <option value="INTELLIGENT" {{$cliEau->TypCompt == "INTELLIGENT" ? 'selected' : ''}}>INTELLIGENT
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="typeReleve">Type de relevé</label>
                    <select id="typeReleve" name="typeReleve" class="form-control inputEau" disabled>
                        <option value="VISU" {{$cliEau->TypRlv == "VISU" ? 'selected' : ''}}>VISU</option>
                        <option value="GPRS" {{$cliEau->TypRlv == "GPRS" ? 'selected' : ''}}>GPRS</option>
                        <option value="RADIO" {{$cliEau->TypRlv == "RADIO" ? 'selected' : ''}}>RADIO</option>
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
                    <label for="consommation">Consommation</label>
                    <input type="text" id="consommation" name="consommation" class="form-control inputEau"
                        value="{{$cliEau->Consom}}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fraisAnnexes">Total des frais annexes</label>
                    <input type="text" id="fraisAnnexes" name="fraisAnnexes" class="form-control inputEau"
                        value="{{$cliEau->FraisAnn}}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="unitesAnnexes">Nombre d'unités pour le calcul des frais annexes</label>
                    <input type="text" id="unitesAnnexes" name="unitesAnnexes" class="form-control inputEau"
                        value="{{$cliEau->UniteAnn}}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="libelleFraisAnnexes">Libellé frais annexes</label>
                    <input type="text" id="libelleFraisAnnexes" name="libelleFraisAnnexes" class="form-control inputEau"
                        value="{{$cliEau->libFrAnn}}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fraisTR">Frais T.R.</label>
                    <input type="text" id="fraisTR" name="fraisTR" class="form-control inputEau"
                        value="{{number_format($cliEau->FraisTR,4)}}" disabled>
                </div>
            </div>
        </div>

        <input type="hidden" name="donneeGenerale" value="eau">
    </form>
</div>
@else
<div class="alert alert-danger" role="alert">
    <i class="fa-regular fa-circle-exclamation me-2"></i>
    Aucune donnée générale pour l'eau
</div>
@endif

@if(isset($error))
<div class="alert alert-info" role="alert">
    <i class="fa-regular fa-circle-info me-2"></i>
    {{ $error }}
</div>
@endif