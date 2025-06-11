<!-- Modal -->
<div class="modal fade" id="appModal_{{$appartement->id}}" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="appModalLabel">Commentaire - App</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal_body">
                <form  action="{{route('immeubles.storeNote', [$appartement->Codecli, $appartement->RefAppTR])}}" method="POST">
                    @csrf
                    <input type="hidden" name="Codecli" id="codeCli_{{ $appartement->Codecli }}" value="{{ $appartement->Codecli }}">
                    <input type="hidden" name="numSerie" id="numSerie_{{ $appartement->numSerie }}" value="{{$numcpt}}">

                    <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">
                    <input type="hidden" name="notesJA" value="">
                    <div class="modal_form">

                        <div class="form-floating my-2">
                            <textarea class="form-control" name="notesCH" placeholder="Leave a comment here" id="TextareaChauf_{{$appartement->id}}" style="height: 100px"></textarea>
                            <label for="notesCH">Commentaire Chauffage</label>
                        </div>
                        <div class="form-floating my-2">
                            <textarea class="form-control" name="notesEC"  placeholder="Leave a comment here" id="TextareaEauCh_{{$appartement->id}}" style="height: 100px"></textarea>
                            <label for="notesEC">Commentaire Eau Chaud</label>
                        </div>
                        <div class="form-floating my-2">
                            <textarea class="form-control" name="notesEF" placeholder="Leave a comment here" id="TextareaEauFr_{{$appartement->id}}" style="height: 100px"></textarea>
                            <label for="notesEF">Commentaire Eau Froid</label>
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
<!-- Modal -->

