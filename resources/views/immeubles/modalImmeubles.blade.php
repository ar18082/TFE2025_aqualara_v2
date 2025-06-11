<!-- Modal -->
<div class="modal fade" id="appModal_{{$appartement->id}}" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="appModalLabel">Commentaire - App</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal_body">
                <form  action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="POST">
                    @csrf
                    <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">
                    <input type="hidden" name="Appartement_id" id="appartement_id_{{ $appartement->id }}" value="{{ $appartement->id }}">
                    <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">
                    <input type="hidden" name="notesCH" value="">
                    <input type="hidden" name="notesEF" value="">
                    <input type="hidden" name="notesEC" value="">
                    <div class="modal_form">
                        <div class="form-floating my-2">
                            <textarea class="form-control" name="notesJA" placeholder="Leave a comment here" id="Textareajustificatif_{{$appartement->id}}" style="height: 100px"></textarea>
                            <label for="notesJA">Justifier Absence</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="modalForm_submit_{{$appartement->id}}">Save changes</button>
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

