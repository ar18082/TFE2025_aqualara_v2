<div class="section-saisie row" style="margin: 0.5rem auto;">
    <h4 class="section-title">Saisie des relevés</h4>
    <x-unlock-note shortcut="§" column="saisie"/>
    @if($datas->count() > 0)
        <table class="table table-bordered">
            <thead>
                @if($type == 'chauffage') 
                    <tr>
                        <th><button id="btn_saisie_numRad" class="table-header-btn">Numéro de radiateur</button></th>
                        <th><button id="btn_saisie_numCal" class="table-header-btn btn_saisie numCal">Numéro de calorimètre</button></th>
                        <th><button id="btn_saisie_typCal" class="table-header-btn btn_saisie typCal">Type d'appareil</button></th>
                        <th><button id="btn_saisie_statut" class="table-header-btn btn_saisie statut">Statut</button></th>
                        <th><button id="btn_saisie_sit" class="table-header-btn btn_saisie sit">Situation</button></th>
                        <th><button id="btn_saisie_coef" class="table-header-btn btn_saisie coef">Coefficient</button></th>
                        <th><button id="btn_saisie_ancIdx" class="table-header-btn btn_saisie ancIdx">Ancien index</button></th>
                        <th><button id="btn_saisie_nvIdx" class="table-header-btn btn_saisie nvIdx">Nouvel index</button></th>
                        <th><button id="btn_saisie_diff" class="table-header-btn ">Différence</button></th>
                    </tr>
                @endif
                @if($type == 'eau' || $type == 'elec' || $type == 'gaz')
                    <tr>
                        <th><button id="btn_saisie_noCpt" class="table-header-btn">No compteur</button></th>
                        <th><button id="btn_saisie_numCpt" class="table-header-btn btn_saisie numCpt">Numéro compteur</button></th>
                        <th><button id="btn_saisie_statut" class="table-header-btn btn_saisie statut">Statut</button></th>
                        <th><button id="btn_saisie_sit" class="table-header-btn btn_saisie sit">Situation</button></th>
                        <th><button id="btn_saisie_ancIdx" class="table-header-btn btn_saisie ancIdx">Ancien index</button></th>
                        <th><button id="btn_saisie_nvIdx" class="table-header-btn btn_saisie nvIdx">Nouvel index</button></th>
                        <th><button id="btn_saisie_diff" class="table-header-btn ">Différence</button></th>
                    </tr>
                @endif
            
            </thead>
            <tbody>
                @foreach($datas as $data)
                @if($type == 'chauffage')
                    <tr>
                        <td><input type="text" class="form-control input_saisie_numRad input-lock" disabled value="{{ $data->NumRad }}"></td>
                        <td><input type="text" class="form-control input_saisie_numCal input-lock" disabled value="{{ $data->NumCal }}"></td>
                        <td><input type="text" class="form-control input_saisie_typCal input-lock" disabled value="{{ $data->TypCal }}"></td>
                        <td><input type="text" class="form-control input_saisie_statut input_saisie input-lock" disabled value="{{ $data->Statut }}"></td>
                        <td><input type="text" class="form-control input_saisie_sit input-lock" disabled value="{{ $data->Sit }}"></td>
                        <td><input type="text" class="form-control input_saisie_coef input-lock" disabled value="{{ $data->Coef }}"></td>
                        <td><input type="text" class="form-control input_saisie_ancIdx input-lock" disabled value="{{ $data->NvIdx }}"></td>
                        <td><input type="text" class="form-control input_saisie_nvIdx input_saisie input-lock" disabled value=""></td>
                        <td><input type="text" class="form-control input_saisie_diff input-lock" disabled value=""></td>
                    </tr>
                @endif
                @if($type == 'eau')
                    <tr>
                        <td><input type="text" class="form-control input_saisie_noCpt input-lock" disabled value="{{ $data->NoCpt }}"></td>
                        <td><input type="text" class="form-control input_saisie_numCpt input-lock" disabled value="{{ $data->NumCpt }}"></td>
                        <td><input type="text" class="form-control input_saisie_statut input_saisie input-lock" disabled value="{{ $data->Statut }}"></td>
                        <td><input type="text" class="form-control input_saisie_sit input-lock" disabled value="{{ $data->Sit }}"></td>
                        <td><input type="text" class="form-control input_saisie_ancIdx input-lock" disabled value="{{ $data->NvIdx }}"></td>
                        <td><input type="text" class="form-control input_saisie_nvIdx input_saisie input-lock" disabled value=""></td>
                        <td><input type="text" class="form-control input_saisie_diff input-lock" disabled value=""></td>
                    </tr>
                @endif
                @if($type == 'gaz' || $type == 'elec')
                    <tr>
                        <td><input type="text" class="form-control input_saisie_noCpt input-lock" disabled value="{{ $data->noCpt }}"></td>
                        <td><input type="text" class="form-control input_saisie_numCpt input-lock" disabled value="{{ $data->numCpt }}"></td>
                        <td><input type="text" class="form-control input_saisie_statut input_saisie input-lock" disabled value="{{ $data->statut }}"></td>
                        <td><input type="text" class="form-control input_saisie_sit input-lock" disabled value="{{ $data->sit }}"></td>
                        <td><input type="text" class="form-control input_saisie_ancIdx input-lock" disabled value="{{ $data->nvIdx }}"></td>
                        <td><input type="text" class="form-control input_saisie_nvIdx input_saisie input-lock" disabled value=""></td>
                        <td><input type="text" class="form-control input_saisie_diff input-lock" disabled value=""></td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        @if($type == 'eau')
            <table class="table table-bordered">
                <thead>
                    
                    <tr>
                        <th><button id="btn_saisie_noCpt" class="table-header-btn">No compteur</button></th>
                        <th><button id="btn_saisie_numCpt" class="table-header-btn btn_saisie numCpt">Numéro compteur</button></th>
                        <th><button id="btn_saisie_statut" class="table-header-btn btn_saisie statut">Statut</button></th>
                        <th><button id="btn_saisie_sit" class="table-header-btn btn_saisie sit">Situation</button></th>
                        <th><button id="btn_saisie_ancIdx" class="table-header-btn btn_saisie ancIdx">Ancien index</button></th>
                        <th><button id="btn_saisie_nvIdx" class="table-header-btn btn_saisie nvIdx">Nouvel index</button></th>
                        <th><button id="btn_saisie_diff" class="table-header-btn ">Différence</button></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas2 as $data)
                        <tr>
                            <td><input type="text" class="form-control input_saisie_noCpt input-lock" disabled value="{{ $data->NoCpt }}"></td>
                            <td><input type="text" class="form-control input_saisie_numCpt input-lock" disabled value="{{ $data->NumCpt }}"></td>
                            <td><input type="text" class="form-control input_saisie_statut input_saisie input-lock" disabled value="{{ $data->Statut }}"></td>
                            <td><input type="text" class="form-control input_saisie_sit input-lock" disabled value="{{ $data->Sit }}"></td>
                            <td><input type="text" class="form-control input_saisie_ancIdx input-lock" disabled value="{{ $data->NvIdx }}"></td>
                            <td><input type="text" class="form-control input_saisie_nvIdx input_saisie input-lock" disabled value=""></td>
                            <td><input type="text" class="form-control input_saisie_diff input-lock" disabled value=""></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
    <div class="alert alert-danger" role="alert">
            Aucun relevé trouvé
        </div>
    @endif
</div>

<style>
    .table-header-btn {
        background: none;
        border: none;
        color: #0d6efd;
        padding: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
        text-align: center;
        position: relative;
    }

    .table-header-btn:hover {
        color: #0a58ca;
        background-color: rgba(13, 110, 253, 0.1);
    }

    .table-header-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #0d6efd;
        transition: all 0.2s ease;
        transform: translateX(-50%);
    }

    .table-header-btn:hover::after {
        width: 80%;
    }

    .table-header-btn.active {
        color: #0a58ca;
        background-color: rgba(13, 110, 253, 0.1);
    }

    .table-header-btn.active::after {
        width: 80%;
    }

    .table th {
        padding: 0;
        vertical-align: middle;
    }

    /* Style pour les cellules avec input déverrouillé */
    td:has(input:not([disabled])) {
        background-color: #e7f1ff !important;
    }

    td:has(input:not([disabled])) input {
        background-color: white !important;
        border-color: #0d6efd !important;
    }

    /* Style pour les cellules avec input verrouillé */
    td:has(input[disabled]) {
        background-color: #f8f9fa !important;
    }

    td:has(input[disabled]) input {
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
    }
</style>


