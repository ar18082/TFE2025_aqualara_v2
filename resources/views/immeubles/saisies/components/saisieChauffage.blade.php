@if($client->clichaufs->count() > 0)
<form action="{{-- route('saisies.chauffage.store')--}}" method="post" id="formChauffage">
    @csrf
    <table class="table table-bordered" id="tableChauff">
        <thead>
            <tr>
                <th><button type="button" class="col-title-btn" data-col="0">Rad.</button></th>
                <th><button type="button" class="col-title-btn" data-col="1">No. Cal</button></th>
                <th><button type="button" class="col-title-btn" data-col="2">Type</button></th>
                <th><button type="button" class="col-title-btn" data-col="3">Statut</button></th>
                <th><button type="button" class="col-title-btn" data-col="4">Situation</button></th>
                <th><button type="button" class="col-title-btn" data-col="5">Coef.</button></th>
                <th><button type="button" class="col-title-btn" data-col="6">Anc. Idx.</button></th>
                <th><button type="button" class="col-title-btn" data-col="7">Nv. Idx.</button></th>
                <th><button type="button" class="col-title-btn" data-col="8">Différence</button></th>

            </tr>
        </thead>
        <tbody>
            @foreach($releves as $key => $releve)
            <tr>
                <td><input type="text" class="form-control table-input inputSaisie" value="{{ $releve->NumRad }}"
                        disabled>
                </td>
                <td><input type="text" class="form-control table-input_1 inputSaisie" value="{{ $releve->NumCal }}"
                        disabled>
                </td>
                <td><input type="text" class="form-control table-input_2 inputSaisie" value="{{ $releve->TypCal }}"
                        disabled>
                </td>
                <td>
                    <select class="form-control table-input_3 inputSaisie saisieStatut" name="statut" id="saisieStatut" disabled>
                        <option value="">Aucun</option>
                        <option value="nouveau">Nouveau</option>
                        <option value="remplace">Remplacer</option>
                        <option value="refix">Refix</option>
                        <option value="bloquer">Bloquer</option>
                        <option value="absent">Absent</option>
                        <option value="casse">Casser</option>
                        <option value="defectueux">Défectueux</option>
                        <option value="illisible">Illisible</option>
                        <option value="forfait">Forfait</option>
                        <option value="supprime">Supprimer</option>
                        
                    </select>
                </td>
                <td><input type="text" class="form-control table-input_4 inputSaisie" value="{{ $releve->Sit }}"
                        disabled>
                </td>
                <td><input type="text" class="form-control table-input_5 inputSaisie" value="{{ $releve->Coef }}"
                        disabled>
                </td>
                <td><input type="text" class="form-control table-input_6 inputSaisie saisieAncIdx"
                        value="{{ $releve->NvIdx }}" disabled>
                </td>
                <td><input type="text" class="form-control table-input_7 inputSaisie saisieNvIdx" value="" disabled>
                </td>
                <td><input type="text" class="form-control table-input inputSaisie saisieDiff" value="" disabled></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-end"><strong>Total :</strong></td>
                <td><input type="text" class="form-control total-anc-idx" readonly></td>
                <td><input type="text" class="form-control total-nv-idx" readonly></td>
                <td><input type="text" class="form-control total-diff" readonly></td>
            </tr>
        </tfoot>
    </table>
    
</form>
{{-- modal pour statut nouveau--}}
<div class="modal fade" id="modalStatut" tabindex="-1" aria-labelledby="modalStatutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStatutLabel">Changement de statut</h5>
            </div>  
            <form id="formStatut" method="post">
                @csrf
                <div class="modal-body">                   
                    <div class="row">
                        <div class="col-md-12">
                            <label for="numeroSerie">Numéro de série</label>
                            <input type="number" class="form-control" id="numeroSerie" name="numeroSerie" required>
                        </div>
                        <div class="col-md-12">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-12">
                            <label for="index">Index</label>
                            <input type="number" class="form-control" id="index" name="index" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitFormStatut">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    Aucune saisie pour le chauffage
</div>
@endif