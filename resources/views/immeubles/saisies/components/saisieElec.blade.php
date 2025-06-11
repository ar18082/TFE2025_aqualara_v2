@if($client->cliElecs->count() > 0)
<form action="{{ route('decompte.storeElec') }}" method="post" id="formElec">
    @csrf
    <table class="table table-bordered" id="tableElec">
        <thead>
            <tr>
                <th><button type="button" class="col-title-btn" data-col="0">No</button></th>
                <th><button type="button" class="col-title-btn" data-col="1">Num. Cpt.</button></th>
                <th><button type="button" class="col-title-btn" data-col="2">Statut</button></th>
                <th><button type="button" class="col-title-btn" data-col="3">Situation</button></th>
                <th><button type="button" class="col-title-btn" data-col="4">Anc. Idx.</button></th>
                <th><button type="button" class="col-title-btn" data-col="5">Nv. Idx.</button></th>
                <th><button type="button" class="col-title-btn" data-col="6">Différence</button></th>
            </tr>
        </thead>
        <tbody>
            @foreach($releves as $key => $releve)
            <tr>
                <td><input type="text" class="form-control table-input inputSaisie" value="{{ $releve->Num }}" disabled>
                </td>
                <td><input type="text" class="form-control table-input_1 inputSaisie" value="{{ $releve->NumCpt }}"
                        disabled>
                </td>
                <td>
                    <select class="form-control table-input_2 inputSaisie" name="statut" id="saisieStatut" disabled>
                        <option value="">Aucun</option>
                        <option value="nouveau">Nouveau</option>
                        <option value="remplace">Remplacé</option>
                        <option value="refix">Refix</option>
                        <option value="bloquer">Bloquer</option>
                        <option value="absent">Absent</option>
                        <option value="casse">Cassé</option>
                        <option value="defectueux">Défectueux</option>
                        <option value="illisible">Illisible</option>
                        <option value="forfait">Forfait</option>
                        <option value="supprimer">Supprimer</option>
                    </select>
                </td>
                <td><input type="text" class="form-control table-input_3 inputSaisie" value="{{ $releve->Sit }}"
                        disabled>
                </td>
                <td><input type="text" class="form-control table-input_4 inputSaisie saisieAncIdx"
                        value="{{ $releve->NvIdx }}" disabled>
                </td>
                <td><input type="text" class="form-control table-input_5 inputSaisie saisieNvIdx" value="" disabled>
                </td>
                <td><input type="text" class="form-control table-input inputSaisie saisieDiff" value="" disabled></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</form>
@else
<div class="alert alert-danger" role="alert">
    Aucune saisie pour l'électricité
</div>
@endif