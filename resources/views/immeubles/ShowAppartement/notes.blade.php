<div class="mb-3" id="notesAppartement">
    <div class="notes-section">
        <h2 class="section-header">
            Notes/Commentaires
        </h2>

        <div class="section-body bg-primary">
<table class="table">
    <thead>
        <tr>
            <th scope="col">Commentaire </th>
            <th scope="col">Type</th>

            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notes as $note)
            @if($note->type == 'JA')
                <tr>
                    <td>
                        <div class="form-floating my-2">
                            <input class="form-control" readonly name="notes" placeholder="Leave a comment here"  style="height: 20px" value="{{$note->note}}">
                        </div>
                    </td>
                    <td>
                        <div class="form-floating my-2">
                            <input class="form-control" readonly type="text" style="height: 20px" value="Absence">
                        </div>
                    </td>
                    <td>
                        <div class="form-floating my-2">
                            <input class="form-control" readonly type="date" style="height: 20px" value="{{$note->created_at->format('Y-m-d')}}">
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

        </div>
    </div>


</div>
