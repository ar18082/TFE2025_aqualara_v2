@if($client)
<div id="detailProvision" class="detail-section">
    <form method="POST" action="{{route('immeubles.provisionUpdate', $client->Codecli)}}">
        @csrf
        <div class="section-header">
            <div class="section-title-container">
                <h2 class="section-title">Gestion des Provisions</h2>
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

        <div class="provision-filters">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="typeRepartition">Type de répartition</label>
                        <select class="form-select inputProvision" id="typeRepartition" name="typeRepartition">
                            <option value="APPART" selected>Encodage Appartement</option>
                            <option value="NBAPP">Montant Global Reparti par Appartement</option>
                            <option value="NBQUOT">Montant Global Reparti sur les Quotités</option>
                            <option value="CLE">Montant Global Reparti sur une Autre Clé de Répartition</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dateDecompte">Date de décompte</label>
                        <input type="date" class="form-control inputProvision" id="dateDecompte" name="dateDecompte">
                    </div>
                </div>
            </div>
        </div>

        <div class="section-header mt-4">
            <div class="section-title-container">
                <h2 class="section-title">Données des appartements</h2>
            </div>
        </div>

        <div class="provision-table">
            <table class="table table-bordered" id="tableProvision">
                <thead>
                    <tr>
                        <th class="readonly-column">RefAppTR</th>
                        <th>RefAppCli</th>
                        <th>Quotité</th>
                        <th>Rad.</th>
                        <th>Cpt Eau Froide</th>
                        <th>Cpt Eau Chaude</th>
                        <th>Gaz</th>
                        <th>Elec</th>
                        <th class="provision-column">Provision</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->appartements as $key => $appartement)
                    <tr>
                        <td>
                            <input type="text" id="{{$key . '_a'}}" readonly class="table-input inputProvision"
                                name="{{'refAppTR_'.$key}}"
                                value="{{$appartement->RefAppTR = $key + 1 ? $appartement->RefAppTR : $key + 1 }}"
                                disabled>
                            <input type="hidden" name="codeCli" value="{{$appartement->Codecli}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_b'}}" class="table-input inputProvision"
                                name="{{'refAppCli_'. $key}}" readonly value="{{$appartement->RefAppCli}}" disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_c'}}" class="table-input inputProvision"
                                name="{{'Quot_'. $key}}" readonly
                                value="{{$client->relChaufApps->isNotEmpty() ? $client->relChaufApps->first()->AppQuot : ''}}"
                                disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_d'}}" class="table-input inputProvision"
                                name="{{'NbRad_'. $key}}" readonly
                                value="{{$appartement->relChaufApps->where('RefAppTR', $appartement->RefAppTR)->first()?->NbRad ?? 0}}"
                                disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_e'}}" class="table-input inputProvision"
                                name="{{'NbCptFroid_'. $key}}" readonly
                                value="{{$appartement->relEauApps->where('RefAppTR', $appartement->RefAppTR)->first()?->NbCptFroid ?? 0}}"
                                disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_f'}}" class="table-input inputProvision"
                                name="{{'NbCptChaud_'. $key}}" readonly
                                value="{{$appartement->relEauApps->where('RefAppTR', $appartement->RefAppTR)->first()?->NbCptChaud ?? 0}}"
                                disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_g'}}" class="table-input inputProvision"
                                name="{{'nbCpt_'. $key}}"
                                value="{{$appartement->relGazApps->where('RefAppTR', $appartement->RefAppTR)->first()?->nbCpt ?? 0}}"
                                readonly disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_h'}}" class="table-input inputProvision"
                                name="{{'nbCpt__'. $key}}"
                                value="{{$appartement->relElecApps->where('RefAppTR', $appartement->RefAppTR)->first()?->nbCpt ?? 0}}"
                                readonly disabled>
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_i'}}"
                                class="table-input table_input_provision inputProvision" name="{{'Provision_'. $key}}"
                                disabled>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>
@else
<div class="alert alert-danger" role="alert">
    <i class="fa-regular fa-circle-exclamation me-2"></i>
    Aucune donnée disponible
</div>
@endif

@if(isset($error))
<div class="alert alert-info" role="alert">
    <i class="fa-regular fa-circle-info me-2"></i>
    {{ $error }}
</div>
@endif