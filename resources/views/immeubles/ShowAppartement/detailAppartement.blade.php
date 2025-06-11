<div id="detailApp">
    <h1>Détail Appartement</h1>
    <form action="{{route('immeubles.DetailUpdate', ['Codecli'=> $appartement->Codecli, 'appartement_id' => $appartement->RefAppTR])}}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="RefAppTR">RefAppTR</label>
                            <input type="text" class="form-control" id="RefAppTR" name="RefAppTR" value="{{$appartement->RefAppTR}}">
                        </div>
                        <div class="form-group">
                            <label for="DesApp">DesApp</label>
                            <input type="text" class="form-control" id="DesApp" name="DesApp" value="{{$appartement->DesApp}}">
                        </div>
                        <div class="form-group">
                            <label for="RefAppCli">RefAppCli</label>
                            <input type="text" class="form-control" id="RefAppCli" name="RefAppCli" value="{{$appartement->RefAppCli}}">
                        </div>
                        <div class="form-group">
                            <label for="proprietaire">proprietaire</label>
                            <input type="text" class="form-control" id="proprietaire" name="proprietaire" value="{{$appartement->proprietaire}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="RefAppCli">datefin</label>
                            <input type="date" class="form-control" id="datefin" name="datefin" value="{{$appartement->datefin}}">
                        </div>
                        <div class="form-group">
                            <label for="lancod">lancod</label>
                            <input type="text" class="form-control" id="lancod" name="lancod" value="{{$appartement->lancod}}">
                        </div>
                        <div class="form-group">
                            <label for="bloc">bloc</label>
                            <input type="text" class="form-control" id="bloc" name="bloc" value="{{$appartement->bloc}}">
                        </div>

                        <div class="form-group">
                            <label for="Cellule">Cellule</label>
                            <input type="text" class="form-control" id="Cellule" name="Cellule" value="{{$appartement->Cellule}}">
                        </div>
                        <div class="form-group">
                            <label for="absent">Date dernière absence</label>

                                @foreach($appartement->absent as $absent)
                                    <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($absent->updated_at)->format('d-m-Y')}}">
                                @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{--<div class="row" id="propertyForm">--}}
{{--    <div class="col-6">--}}
{{--        @include('shared.input', ['label' => 'RefAppCli', 'name' => 'RefAppCli', 'placeholder' => 'RefAppCli', 'value' => old('RefAppCli', $property->RefAppCli)])--}}

{{--        @include('shared.input', ['label' => 'RefAppTR', 'name' => 'RefAppTR', 'placeholder' => 'RefAppTR', 'value' => $lastRefAppTR ? : old('ReAppTR', $property->RefAppTR)])--}}

{{--        @include('shared.input', ['label'=> 'Nbr Rep Facture', 'name' =>'nbr_RepFact', 'placeholder'=> 'Rep Facture'])--}}

{{--        @include('shared.input', ['label'=> 'Nbr Quotités ', 'name' =>'nbr_Quot', 'placeholder'=> 'Nbr Quotités '])--}}

{{--        @include('shared.input', ['label'=> 'Nom propriétaire', 'name' =>'NomProp', 'placeholder'=> 'Nom Propriétaire ', 'value' => $property ? $ProprioCd : ''])--}}

{{--    </div>--}}
{{--    <div class="col-6">--}}
{{--        @include('shared.input', ['label'=> 'Nbr Radiateur', 'name' =>'nbr_radiateur', 'placeholder'=> 'Nbr Radiateur', 'value' => $property ? $nbr_chauf : '0'])--}}
{{--        @include('shared.input', ['label'=> 'Nbr Compteur EC', 'name' =>'nbr_ComptEC', 'placeholder'=> 'Nbr Compteur EC', 'value' => $property ? $nbr_eauC : '0'])--}}
{{--        @include('shared.input', ['label'=> 'Nbr Compteur EF', 'name' =>'nbr_ComptEF', 'placeholder'=> 'Nbr Compteur EF', 'value' => $property ? $nbr_eauF : '0'])--}}



{{--        @include('shared.input', ['label'=> 'Nom locataire', 'name' =>'NomLoc', 'placeholder'=> 'Nom locataire ', 'value' => $property ? $LocatCd : ''])--}}

{{--    </div>--}}
{{--</div>--}}
