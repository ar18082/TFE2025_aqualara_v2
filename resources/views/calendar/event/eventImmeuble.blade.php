<div id="rdvImmeuble" style="display: none">
    <div class="row">
        <div class="col-2">
            <a href="{{route('admin.event.create', ['client_id' => $client->id])}}" class="btn btn-primary m-4" id="btnNouveau">Nouveau</a>
        </div>
        <div class="col-10">
            <form id="formEvent"  >
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-light">Type d'intervention</div>
                        <div class="input-group input-group-sm">
                            <select type="text" class="form-control TypeInter" id="TypeInter" name="TypeInter"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-light">Date</div>
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control" name="date" id="date">
                        </div>
                    </div>
                    <div class="col-md-2 m-2">
                        <button type="button" id="submitFormEvent" style="display: block">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
{{--    <ul class="nav nav-tabs mt-3">--}}
{{--        <li class="nav-item">--}}
{{--            <button class="nav-link active " id="btnToDay" >Aujourd'hui</button>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <button class="nav-link " id="btnFutur" >Future</button>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <button class="nav-link" id="btnAPlanifier">A planifier</button>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <button class="nav-link " id="btnHistorique" >Historique</button>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a href="{{route('admin.event.create', ['client_id' => $client->id])}}" class="nav-link"  id="btnNouveau">Nouveau</a>--}}
{{--        </li>--}}

{{--    </ul>--}}

    <table class="table table-striped mt-4">
        <thead>
        <tr>

            <th>Date</th>
            <th>Quart</th>
            <th>CodeCli</th>
            <th>Nom Client</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Intervention</th>
            <th>Technicien</th>
            <th>Commentaire</th>
            <th>Actions</th>

        </tr>
        </thead>
        <tbody id="eventBody">
        </tbody>
    </table>
</div>
