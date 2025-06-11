<div class="appartContent card mb-3 border-0 {{ $bg_card }} shadow-sm hover-shadow">
    <div class="card-body p-2">
        <div class="row g-2 align-items-center">
            <!-- Code Appartement -->
            <div class="col-lg-2 col-md-2">
                <a href="{{ route('immeubles.showAppartement', [$client->Codecli, $appartement->RefAppTR] ) }}"
                    class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-primary rounded-pill px-2 py-1">
                            {{ str_pad($appartement->RefAppTR, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </a>
            </div>

            <!-- Propriétaire -->
            <div class="col-lg-2 col-md-2">
                <a href="{{ route('immeubles.showAppartement', [$client->Codecli, $appartement->RefAppTR] ) }}"
                    class="text-decoration-none">
                    <div class="d-flex align-items-center text-dark">
                        <i class="fa-regular fa-key me-2 text-primary"></i>
                        <span class="text-truncate">{{ $appartement->relApp->ProprioCd ?? 'Non assigné' }}</span>
                    </div>
                </a>
            </div>

            <!-- Occupant -->
            <div class="col-lg-2 col-md-2">
                <a href="{{ route('immeubles.showAppartement', [$client->Codecli, $appartement->RefAppTR] ) }}"
                    class="text-decoration-none">
                    <div class="d-flex align-items-center text-dark">
                        <i class="fa-regular fa-user-group-simple me-2 text-primary"></i>
                        <span class="text-truncate">{{ $appartement->relApp->LocatCd ?? 'Non assigné' }}</span>
                    </div>
                </a>
            </div>

            <!-- Compteurs -->
            <div class="col-lg-3 col-md-3">
                <div class="d-flex gap-1">
                    @foreach($appartement->compteurs as $compteur)
                    <div class="compteur-badge {{ $compteur['bg'] }} {{ $compteur['text'] }}" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="{{ $compteur['label'] }}">
                        <i class="fa-regular {{ $compteur['icon'] }} me-1"></i>
                        <span>{{ $compteur['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="col-lg-3 col-md-3">
                <div class="d-flex justify-content-end align-items-center gap-5">
                    <div class="form-check form-switch">
                        <form method="POST"
                            action="{{ route('immeubles.storeAbsent', [$client->Codecli, $appartement->RefAppTR] ) }}"
                            id="absentForm_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                            @csrf
                            <input type="hidden" name="Codecli" value="{{ $client->Codecli }}">
                            <input type="hidden" name="Appartement_id" value="{{ $appartement->id }}">
                            <input type="hidden" name="RefAppTR" value="{{ $appartement->RefAppTR }}">
                            <input class="form-check-input" type="checkbox" value="1"
                                id="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}"
                                name="is_absent" @if(count($appartement->Absent) > 0 &&
                            $appartement->Absent[count($appartement->Absent)-1]->is_absent == '1') checked @endif
                            onchange="submitForm('{{ $client->Codecli }}_{{ $appartement->RefAppTR }}')">
                            <label class="form-check-label"
                                for="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                                Absent
                            </label>
                        </form>
                    </div>

                    <div class="d-flex gap-5">
                        <button type="button" class="btn btn-light btn-sm" id="note_{{ $appartement->id }}"
                            data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">
                            <i class="fa-regular fa-note-sticky"></i>
                        </button>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#Modal_img_{{$appartement->id}}">
                            <i class="fa-regular fa-file-image"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>