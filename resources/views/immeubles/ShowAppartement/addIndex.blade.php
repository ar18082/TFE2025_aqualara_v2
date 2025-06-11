<div id="addIndexApp">
    <div id="successMessage"></div>
    <div class="d-flex justify-content-between align-items-center">
        <h1 id="title">@yield('title')</h1>

    </div>

    <hr>

    <form action="{{route('immeubles.AddIndex', ['Codecli_id'=> 1, 'appartement_id' => 1])}}" method="POST">
        @csrf
{{--        @method('PUT')--}}
        <div class="row mt-2">
            <h3 class="mt-4">Enregistrement Calorimètre </h3>
            <table class="table" >
                <thead>
                <tr>
                    <th scope="col">N° Série </th>
                    <th scope="col">Situation</th>
                    <th scope="col">Coefficient</th>
                    <th scope="col">index</th>
                    <th scope="col">Actif</th>
                </tr>
                </thead>
                <tbody id="tbody_cal">
                        @foreach($releves as $item)
                            @if($item->getTable() == 'rel_chaufs')
                                @php($switchChecked = 'checked')
                                @foreach($appareilsErreurs as $appareilErreur)
                                    @if($appareilErreur->appareil->numSerie == $item->NumCal)
                                        @php($switchChecked = '')
                                    @endif
                                @endforeach
                                <input type="hidden" name="table-{{$item->NumCal}}" value="{{$item->getTable()}}">
                            <tr id="row_cal" >
                                <td><input type="text" class="form-control"  id="NumCal-{{$item->NumCal}}" name="NumCal-{{$item->NumCal}}" maxlength="8" pattern="[0-9]{8}" value="{{$item->NumCal}}"></td>
                                <td><input type="text" class="form-control " id="Sit-{{$item->NumCal}}" name="Sit-{{$item->NumCal}}" value="{{$item->Sit}}"></td>
                                <td><input type="text" class="form-control " id="Coef-{{$item->NumCal}}" name="Coef-{{$item->NumCal}}" value="{{$item->Coef}}"></td>
                                <td><input type="text" class="form-control" id="index-{{$item->NumCal}}" name="index-{{$item->NumCal}}" {{$switchChecked != 'checked'? 'readOnly' : ''}}></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="actif-{{$item->NumCal}}" name="actif-{{$item->NumCal}}" {{$switchChecked}}>
                                    </div>
                                </td>
                            </tr>
                                <input type="hidden" name="NumRad-{{$item->NumCal}}" value="{{$item->NumRad}}">
                            @endif
                        @endforeach
                </tbody>
            </table>
            <h3 class="mt-4">Enregistrement Compteur EC </h3>
            <table class="table" >
                <thead>
                <tr>
                    <th scope="col">N° Série</th>
                    <th scope="col">num compteur</th>
                    <th scope="col">AncIdx</th>
                    <th scope="col">index</th>
                    <th scope="col">Actif</th>
                </tr>
                </thead>
                <tbody id="tbody_cpt_EC">
                @foreach($releves as $item)
                    @if($item->getTable() == 'rel_eau_c_s')
                        @php($switchChecked = 'checked')
                        @foreach($appareilsErreurs as $appareilErreur)
                            @if($appareilErreur->appareil->numSerie == $item->NoCpt)
                                @php($switchChecked = '')
                            @endif
                        @endforeach

                        <input type="hidden" name="table-{{$item->NoCpt}}" value="{{$item->getTable()}}">
                        <tr id="row_EC" >
                            <td><input type="text" class="form-control"  id="NoCpt-{{$item->NoCpt}}" name="NoCpt-{{$item->NoCpt}}" value="{{$item->NoCpt}}" {{--maxlength="8" pattern="[0-9]{8}"--}} ></td>
                            <td><input type="text" class="form-control " id="NumCpt-{{$item->NoCpt}}" name="NumCpt-{{$item->NoCpt}}" value="{{$item->NoCpt}}"></td>
                            <td><input type="text" class="form-control " id="AncIdx-{{$item->NoCpt}}" name="AncIdx-{{$item->NoCpt}}" value="{{$item->AncIdx}}"></td>
                            <td><input type="text" class="form-control " id="index-{{$item->NoCpt}}" name="index-{{$item->NoCpt}}" {{$switchChecked != 'checked'? 'readOnly' : ''}}></td>

                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="actif-{{$item->NoCpt}}" name="actif-{{$item->NoCpt}}" {{$switchChecked}}>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h3 class="mt-4">Enregistrement Compteur EF </h3>
            <table class="table" >
                <thead>
                <tr>
                    <th scope="col">N° Série</th>
                    <th scope="col">num compteur</th>
                    <th scope="col">AncIdx</th>
                    <th scope="col">index</th>
                    <th scope="col">Actif</th>
                </tr>
                </thead>
                <tbody id="tbody_cpt_EF">
                @foreach($releves as $item)
                    @if($item->getTable() == 'rel_eau_f_s')
                        @php($switchChecked = 'checked')
                        @foreach($appareilsErreurs as $appareilErreur)
                            @if($appareilErreur->appareil->numSerie == $item->NoCpt)
                                @php($switchChecked = '')
                            @endif
                        @endforeach
                        <input type="hidden" name="table-{{$item->NoCpt}}" value="{{$item->getTable()}}">
                        <tr id="row_EC" >
                            <td><input type="text" class="form-control"  id="NoCpt-{{$item->NoCpt}}" name="NoCpt-{{$item->NoCpt}}" value="{{$item->NoCpt}}" {{--maxlength="8" pattern="[0-9]{8}"--}} ></td>
                            <td><input type="text" class="form-control " id="NumCpt-{{$item->NoCpt}}" name="NumCpt-{{$item->NoCpt}}" value="{{$item->NoCpt}}"></td>
                            <td><input type="text" class="form-control " id="AncIdx-{{$item->NoCpt}}" name="AncIdx-{{$item->NoCpt}}" value="{{$item->AncIdx}}"></td>
                            <td><input type="text" class="form-control " id="index-{{$item->NoCpt}}" name="index-{{$item->NoCpt}}" {{$switchChecked != 'checked'? 'readOnly' : ''}}></td>

                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="actif-{{$item->NoCpt}}" name="actif-{{$item->NoCpt}}" {{$switchChecked}}>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">

                <button type="submit"  id='submit' class="btn btn-primary w-25" >
                    @if($client->exists)
                        Modifier
                    @else
                        Enregistrer
                    @endif
                </button>
            </div>

        </div>
</div>


