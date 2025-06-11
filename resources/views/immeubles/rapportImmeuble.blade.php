<div id="rapportImmeuble" style="display: none" >
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card">
                <div class="card-header row">
                    <div class="col-1"></div>
                    <div class="col-3">
                        <h4>Rapport</h4>
                    </div>
                    <div class="col-5"></div>
                    <div class="col-3 ">
                        <a href="{{route('documents.editRapport', $client->id)}}" class="btn btn-primary">Générer un rapport</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-1"></div>
        <div class="col-10 ">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Lien</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        @if($document->type == 'Rapport')
                        <tr>
                            <td>{{$document->created_at}}</td>
                            <td><a href="{{route('documents.showRapport', $client->id)}}" target="_blank">{{$document->link}}</a></td>
                            <td>
                                <a href="{{route('documents.editRapport', $client->id)}}" class="btn btn-primary">Modifier</a>
                                <a href="{{route('documents.deleteRapport', [$client->id, $document->created_at])}}" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
