@extends('base')
@section('title', 'Formulaire Avis passage text')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @if($avisPassageText->exists)
                    <h2>Modifier le texte d'un Avis de Passage</h2>
                @else
                    <h2>Créer le texte d'un Avis de Passage</h2>
                @endif
                    <a class="btn btn-secondary" href="{{route('admin.avisPassageText.index')}}">Retour</a>
                <form action="{{$avisPassageText->exists ? route('admin.avisPassageText.update',$avisPassageText->id) : route('admin.avisPassageText.store')}}"
                      method="POST" class="mt-5">
                    @csrf
                    @if($avisPassageText->exists)
                        @method("PUT")
                    @endif
                    <div class="mb-3">
                        <label for="typRlv" class="form-label">Type relevé</label>
                        <select class="form-select" id="typRlv" name="typRlv">
                            <option value="VISU">VISU</option>
                            <option value="RADIO/GPRS">RADIO/GPRS</option>
                            <option value="MIXTE">MIXTE</option>
                            <option value="AUTRE">AUTRE</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="typeEvent" class="form-label">Type d'événement</label>
                        <select class="form-select" id="typeEvent" name="typeEvent">
                            @foreach($typeEvents as $typeEvent)
                                <option value="{{ $typeEvent->id }}" {{ isset($avisPassageText) && $avisPassageText->type_event_id == $typeEvent->id ? 'selected' : '' }}>{{ $typeEvent->abreviation }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="typePassage" class="form-label">Type de passage</label>
                        <input type="text" class="form-control" id="typePassage" name="typePassage" value="{{ isset($avisPassageText) ? $avisPassageText->typePassage : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="acces" class="form-label">Accès</label>
                        <textarea class="form-control" id="acces" name="acces">{{ isset($avisPassageText) ? $avisPassageText->acces : '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="presence" class="form-label">Présence</label>
                        <textarea class="form-control" id="presence" name="presence">{{ isset($avisPassageText) ? $avisPassageText->presence : '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="coupure" class="form-label">Coupure</label>
                        <textarea class="form-control" id="coupure" name="coupure">{{ isset($avisPassageText) ? $avisPassageText->coupure : '' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $avisPassageText->exists ? 'Modifier' : 'Ajouter' }}</button>
                </form>
            </div>
        </div>
    </div>

@endsection
