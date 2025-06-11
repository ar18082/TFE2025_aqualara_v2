@if($client->cliEaus->count() > 0)

<form method="POST" action="" id="formEau">
    @csrf
    <table class="table table-bordered" id="tableEauC">
        <thead>
            <tr>
                <th colspan="8" class="text-center bg-info  text-white">Eau Froide</th>
            </tr>
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
            @foreach($relEauFs as $relEauF)
            <tr>
                <td><input type="text" class="form-control table-input inputSaisie" value="{{ $relEauF->NumCpt }}" disabled></td>
                <td><input type="text" class="form-control table-input_1 inputSaisie" value="{{ $relEauF->NoCpt }}" disabled></td>
                <td> 
                    <select class="form-control table-input_2 inputSaisie" name="statut" id="saisieStatut" disabled>
                        <option value="">Aucun</option>
                        <option value="nouveau">Nouveau</option>
                        <option value="remplace">Remplacé</option>
                        <option value="absent">Absent</option>
                        <option value="casse">Cassé</option>
                        <option value="defectueux">Défectueux</option>
                        <option value="illisible">Illisible</option>
                        <option value="forfait">Forfait</option>
                        <option value="supprime">Supprimé</option>
                    </select>
                </td>
                <td><input type="text" class="form-control table-input_3 inputSaisie" value="{{ $relEauF->Sit }}" disabled></td>
                <td><input type="text" class="form-control table-input_4 inputSaisie saisieAncIdx" value="{{ $relEauF->NvIdx }}" disabled></td>
                <td>
                    <input type="text" class="form-control table-input_5 inputSaisie saisieNvIdx" value="" disabled>
                </td>
                <td>
                    <input type="text" class="form-control table-input_6 inputSaisie saisieDiff" value="" disabled>
                    <input type="hidden" class="saisieType" value="froide" disabled>
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="8" class="text-center bg-danger text-white">Eau Chaude</td>
            </tr>
            @foreach($relEauCs as $relEauC)
            <tr>
                <td><input type="text" class="form-control table-input inputSaisie" value="{{ $relEauC->NumCpt }}" disabled></td>
                <td><input type="text" class="form-control table-input_1 inputSaisie" value="{{ $relEauC->NoCpt }}" disabled></td>
                <td> 
                    <select class="form-control table-input_2 inputSaisie" name="statut" id="saisieStatut" disabled>
                        <option value="">Aucun</option>
                        <option value="nouveau">Nouveau</option>
                        <option value="remplacer">Remplacer</option>
                        <option value="remplacer_module">Remplacer module</option>
                        <option value="absent">Absent</option>
                        <option value="casse">Cassé</option>
                        <option value="defectueux">Défectueux</option>
                        <option value="illisible">Illisible</option>
                        <option value="forfait">Forfait</option>
                        <option value="envers">Envers</option>
                        <option value="bloquer">Bloquer</option>
                        <option value="supprimer">Supprimer</option>
                    </select>
                </td>
                <td><input type="text" class="form-control table-input_3 inputSaisie" value="{{ $relEauC->Sit }}" disabled></td>
                <td><input type="text" class="form-control table-input_4 inputSaisie saisieAncIdx" value="{{ $relEauC->NvIdx }}" disabled></td>
                <td>
                    <input type="text" class="form-control table-input_5 inputSaisie saisieNvIdx" value="" disabled>
                </td>
                <td>
                    <input type="text" class="form-control table-input_6 inputSaisie saisieDiff" value="" disabled>
                    <input type="hidden" class="saisieType" value="chaude" disabled>
                </td>
            </tr>
            @endforeach
           
            
        </tbody>
    </table>
    {{-- <table class="table table-bordered" id="tableEauF">
        <thead>
            <tr>
                <th colspan="8" class="text-center bg-info text-white">Eau Froide</th>
            </tr>
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
            @foreach($relEauFs as $relEauF)
            <tr>
                <td><input type="text" class="form-control table-input inputSaisie" value="{{ $relEauF->NoCpt }}" disabled></td>
                <td><input type="text" class="form-control table-input_1 inputSaisie" value="{{ $relEauF->NumCpt }}" disabled></td>
                <td> 
                    <select class="form-control table-input_2 inputSaisie" name="statut" id="saisieStatut" disabled>
                        <option value="">Aucun</option>
                        <option value="nouveau">Nouveau</option>
                        <option value="remplace">Remplacé</option>
                        <option value="absent">Absent</option>
                        <option value="casse">Cassé</option>
                        <option value="defectueux">Défectueux</option>
                        <option value="illisible">Illisible</option>
                        <option value="forfait">Forfait</option>
                        <option value="supprime">Supprimé</option>
                    </select>
                </td>
                <td><input type="text" class="form-control table-input_3 inputSaisie" value="{{ $relEauF->Sit }}" disabled></td>
                <td><input type="text" class="form-control table-input_4 inputSaisie saisieAncIdx" value="{{ $relEauF->NvIdx }}" disabled></td>
                <td>
                    <input type="text" class="form-control table-input_5 inputSaisie saisieNvIdx" value="" disabled>
                </td>
                <td><input type="text" class="form-control table-input_6 inputSaisie saisieDiff" value="" disabled></td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
</form>

@else
<div class="alert alert-danger" role="alert">
    Aucune saisie pour les eaux
</div>
@endif