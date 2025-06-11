@php
    $numSerie ??= true;
    $value ??= '';


@endphp

<div class="modal fade" id="Modal_img_{{$appartement->id}}" tabindex="-1" aria-labelledby="exampleModalLabel_{{$appartement->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_{{$appartement->id}}">Ajouter une image</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('immeubles.file_storage.store')}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">
                    @if($numSerie)
                        <input type="hidden" name="numSerie" id="numSerie_{{$client->Codecli}}" value="{{$value}}">
                    @endif
                    <div class="form-floating mb-3">
                        <input type="file" id="files" name="files[]" multiple><br><br>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                        <label for="description">Description</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-25">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
