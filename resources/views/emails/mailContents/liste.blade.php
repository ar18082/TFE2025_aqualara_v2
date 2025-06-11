<div id="containerListe">
    <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Type intervention</th>
                <th>Type relevé</th>
                <th>Sujet</th>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mailContents as $content)

                <tr >
                    <td>{{$content->id}}</td>
                    <td>{{$content->typeEvent ? $content->typeEvent->name : 'Non défini'}}</td>
                    <td>{{$content->typeRlv != null ? $content->typeRlv : 'Non défini'}}</td>
                    <td>{{$content->subject}}</td>
                    <td>{{$content->content}}</td>
                    <td>
                        <a href="{{route("mailContents.edit", $content->id)}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{route("mailContents.edit", $content->id)}}" class="btn btn-primary">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form action="{{ route('mailContents.destroy', $content->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
    </table>
</div>
