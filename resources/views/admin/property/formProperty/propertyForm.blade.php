<div class="row" id="propertyForm">
    <div class="col-6">
        @include('shared.input', ['label' => 'RefAppCli', 'name' => 'RefAppCli', 'placeholder' => 'RefAppCli', 'value' => old('RefAppCli', $client[0]->appartements[0]->RefAppCli)])

        @include('shared.input', ['label' => 'RefAppTR', 'name' => 'RefAppTR', 'placeholder' => 'RefAppTR', 'value' => old('ReAppTR', $client[0]->appartements[0]->RefAppTR)])

        @include('shared.input', ['label'=> 'Nbr Rep Facture', 'name' =>'nbr_RepFact', 'placeholder'=> 'Rep Facture'])

        @include('shared.input', ['label'=> 'Nbr Quotités ', 'name' =>'nbr_Quot', 'placeholder'=> 'Nbr Quotités ' , 'value' => old('ReAppTR', $client[0]->clichaufs[0]->Quotite)])

        @include('shared.input', ['label'=> 'Nom propriétaire', 'name' =>'ProprioCd', 'placeholder'=> 'Nom Propriétaire ', 'value' => old('ProprioCd', $client[0]->relApps[0]->ProprioCd)])

    </div>
    <div class="col-6">
        @include('shared.input', ['label'=> 'Nbr Radiateur', 'name' =>'nbr_radiateur', 'placeholder'=> 'Nbr Radiateur', 'value' => old('NbRad', $client[0]->relChaufApps[0]->NbRad)])
        @include('shared.input', ['label'=> 'Nbr Compteur EC', 'name' =>'nbr_ComptEC', 'placeholder'=> 'Nbr Compteur EC', 'value' => old('NbRad', $client[0]->relEauApps[0]->NbCptChaud)])
        @include('shared.input', ['label'=> 'Nbr Compteur EF', 'name' =>'nbr_ComptEF', 'placeholder'=> 'Nbr Compteur EF', 'value' => old('NbRad', $client[0]->relEauApps[0]->NbCptFroid)])



        @include('shared.input', ['label'=> 'Nom locataire', 'name' =>'NomLoc', 'placeholder'=> 'Nom locataire ', 'value' => old('ProprioCd', $client[0]->relApps[0]->LocadCd)])

    </div>
</div>

        <input type="hidden" name="Codecli" value="{{ $client[0]->appartements[0]->Codecli }}">



