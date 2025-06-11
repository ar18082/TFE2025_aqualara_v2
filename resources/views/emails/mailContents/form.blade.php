<div class="container" id="containerForm">
{{-- create form for the model MailContent --}}
    <form action="{{ $mailContent->exists ? route('mailContents.update', $mailContent->id) : route('mailContents.store') }}" method="POST" class="mt-5">
        @csrf
        @if($mailContent->exists)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="typeEvent">Type d'intervention</label>
            <select name="type_event_id" id="typeEvent" class="form-control">
                    <option value="" {{!$mailContent->exists ? 'selected' : ''}}>Choissir un type d'évenement</option>
                @foreach($typeEvents as $typeEvent)
                    <option value="{{$typeEvent->id}}" {{$typeEvent->id == $mailContent->type_event_id ? 'selected' : ''}}>{{$typeEvent->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="typeEvent">Type de relevé</label>
            <label for="typRlv" class="form-label">Type relevé</label>
            <select class="form-select" id="typeRlv" name="typeRlv">
                <option value="" {{$mailContent->typeRlv == null ? 'selected' : ''}}>Choissir un type de relevé</option>
                <option value="VISU" {{$mailContent->typeRlv == 'VISU' ? 'selected' : ''}}>VISU</option>
                <option value="RADIO/GPRS" {{$mailContent->typeRlv =="RADIO/GPRS"? 'selected' : ''}}>RADIO/GPRS</option>
                <option value="MIXTE" {{$mailContent->typeRlv =="MIXTE"? 'selected' : ''}}>MIXTE</option>
                <option value="AUTRE" {{$mailContent->typeRlv =="AUTRE"? 'selected' : ''}}>AUTRE</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="subject">Sujet</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{$mailContent->exists ? $mailContent->subject : ''}}">
        </div>
        <div class="form-group mb-3">
            <label for="content">Contenu</label>
            <textarea name="content" id="content" class="form-control" style="height: 25rem; width: 100%">{{$mailContent->exists ?$mailContent->content : ''}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

