@if($client)
<div id="infoAppart" class="detail-section">
    <form method="POST" action="{{route('immeubles.infoAppartUpdate', $client->Codecli)}}">
        @csrf
        <input type="hidden" name="codecli" value="{{ $client->Codecli }}">
        <div class="section-header">
            <div class="section-title-container">
                <h2 class="section-title">Informations des Appartements</h2>
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

        <div class="section-header mt-4">
            <div class="section-title-container">
                <h2 class="section-title">Données des appartements</h2>
                <div class="d-flex align-items-center ms-3">
                    <label for="nbAppartements" class="me-2">Nombre d'appartements :</label>
                    <input type="number" id="nbAppartements" class="form-control inputInfoAppart" readonly
                        value="{{ $client->appartements->count() }}" style="width: 80px;">
                    <div class="ms-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#uploadCsvModal">
                            <i class="fa-solid fa-file-csv me-1"></i>Charger CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-appart-table">
            <table class="table table-bordered" id="tableInfoApp">
                <thead>
                    <tr>
                        <th>RefAppTR</th>
                        <th>RefAppCli</th>
                        <th>Propriétaire</th>
                        <th>Locataire</th>
                        <th>Quotité</th>
                        <th>Nb radiateurs</th>
                        <th>Nb compteur EF</th>
                        <th>Nb compteur EC</th>
                        <th>Nb compteur Gaz</th>
                        <th>Nb compteur Elec</th>
                        <th>Date fin</th>
                        <th>Bloc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->appartements as $key => $appartement)
                    <tr>
                        <td>
                            <input type="text" readonly id="{{$key . '_tableInfoApp_a'}}" class="table-input"
                                name="{{'refAppTR_'.$key}}"
                                value="{{$appartement->RefAppTR = $key + 1 ? $appartement->RefAppTR : $key + 1 }}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_b'}}" class="table-input inputInfoAppart"
                                readonly name="{{'refAppCli_'. $key}}" value="{{$appartement->RefAppCli}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_c'}}" class="table-input inputInfoAppart"
                                readonly name="{{'prop_'. $key}}" value="{{$appartement->proprietaire}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_d'}}" class="table-input inputInfoAppart"
                                readonly name="{{'loc_'. $key}}"
                                value="{{ $appartement->relApps && $appartement->relApps->isNotEmpty() ? $appartement->relApps->first()->LocatCd : '' }}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_e'}}" class="table-input inputInfoAppart"
                                readonly name="{{'Quot_'. $key}}"
                                value="{{$appartement->relChaufApps && $client->relChaufApps->isNotEmpty() ? $client->relChaufApps->first()->AppQuot : 0}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_f'}}" class="table-input inputInfoAppart"
                                readonly name="{{'NbRad_'. $key}}"
                                value="{{$appartement->relChaufApps && $appartement->relChaufApps->isNotEmpty() ? $appartement->relChaufApps->first()->NbRad : 0}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_g'}}" class="table-input inputInfoAppart"
                                readonly name="{{'NbCptFroid_'. $key}}"
                                value="{{$appartement->relEauApps && $appartement->relEauApps->isNotEmpty() ? $appartement->relEauApps->first()->NbCptFroid : 0}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_h'}}" class="table-input inputInfoAppart"
                                readonly name="{{'NbCptChaud_'. $key}}"
                                value="{{$appartement->relEauApps && $appartement->relEauApps->isNotEmpty() ? $appartement->relEauApps->first()->NbCptChaud : 0}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_i'}}" class="table-input inputInfoAppart"
                                readonly name="{{'Gaz_'. $key}}"
                                value="{{ $appartement->relGazApps && $appartement->relGazApps->isNotEmpty() ? $appartement->relGazApps->first()->nbCpt : 0 }}">
                        </td>
                        <td>
                            <input type="text" id="{{$key . '_tableInfoApp_j'}}" class="table-input inputInfoAppart"
                                readonly name="{{'Elec_'. $key}}"
                                value="{{$appartement->relElecApps && $appartement->relElecApps->isNotEmpty() ? $appartement->relElecApps->first()->nbCpt : 0}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key. '_tableInfoApp_k'}}" class="table-input inputInfoAppart"
                                readonly name="{{'datefin_' . $key}}"
                                value="{{\Carbon\Carbon::parse($appartement->datefin)->format('d-m-Y')}}">
                        </td>
                        <td>
                            <input type="text" id="{{$key. '_tableInfoApp_l'}}" class="table-input inputInfoAppart"
                                readonly name="{{'bloc_' . $key}}" value="{{$appartement->bloc}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

<!-- Modal pour l'upload CSV -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvModalLabel">Charger un fichier CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('immeubles.infoAppartUpdate.uploadCsv', $client->Codecli)}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="csvFile" class="form-label">Sélectionner un fichier CSV</label>
                        <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv" required>
                        <small class="text-muted">
                            <i class="fa-regular fa-circle-info me-1"></i>
                            Le fichier doit contenir les colonnes : Codecli, RefAppTR, RefAppCli, proprietaire, datefin,
                            bloc
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Charger</button>
                </div>
            </form>
        </div>
    </div>
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