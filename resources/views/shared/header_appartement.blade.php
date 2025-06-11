<div class="card mb-3 border-primary-subtle">
    <div class="card-header text-bg-primary ">
        <i class="fa-regular fa-door-open me-3"></i>
        {{ str_pad($immeuble_id, 4, '0', STR_PAD_LEFT) }}

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9 col-md-3 d-flex">
                @php
                    $relApp = $relApps->where('RefAppTR', $immeuble_id)->last();

                @endphp
                <div class="px-3 my-auto">
                    <i class="fa-regular fa-key me-2 text-primary"></i>
                </div>
                <div>
                    {{ $relApp->ProprioCd ?? '' }}
                </div>

            </div>
            <div class="col-9 col-md-2 d-flex">
                <div class="px-3 my-auto">
                    <i class="fa-regular fa-user-group-simple me-2 text-primary"></i>
                </div>

                <div>
                    {{ $relApp->LocatCd ?? '' }}
                </div>
            </div>
            <div class="col-3 col-md-3">
                @php
                    $nbChauf = $client->relChaufApps->where('RefAppTR',  $immeuble_id)->last();
                    $nbEau = $client->relEauApps->where('RefAppTR',  $immeuble_id)->last();
                    //                var_dump($nbChauf);
                @endphp

                <div class="col-12 d-flex font-monospace fs-6">
                    @if( isset($nbChauf->NbRad) && $nbChauf->NbRad != 0)
                        <div class="bg-warning rounded-circle d-flex mx-1 text-center" style="height: 25px; width: 25px;"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                            <span class="my-auto mx-auto fw-bold">{{ $nbChauf->NbRad  }}</span>
                        </div>
                    @endif
                    @if( isset($nbEau->NbCptChaud) && $nbEau->NbCptChaud != 0)
                        <div class="bg-danger rounded-circle d-flex mx-1" style="height: 25px; width: 25px;">
                            <span class="my-auto mx-auto fw-bold">{{ $nbEau->NbCptChaud }} </span>
                        </div>
                    @endif
                    @if( isset($nbEau->NbCptFroid) && $nbEau->NbCptFroid != 0)
                        <div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;">
                            <span class="my-auto mx-auto fw-bold">{{ $nbEau->NbCptFroid  }}</span>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-3 col-md-2">
                <form method="POST" action="{{ route('immeubles.storeAbsent', [$client->Codecli, $appartement->RefAppTR] ) }}" id="absentForm_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                    @csrf
                    <input type="hidden" name="Codecli" value="{{ $client->Codecli }}">
                    <input type="hidden" name="Appartement_id" value="{{ $appartement->id }}">
                    <input type="hidden" name="RefAppTR" value="{{ $appartement->RefAppTR }}">
                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}" name="is_absent" @if(count($appartement->Absent) > 0 && $appartement->Absent[count($appartement->Absent)-1]->is_absent == '1') checked @endif onchange="submitForm('{{ $client->Codecli }}_{{ $appartement->RefAppTR }}')">
                    <label class="form-check-label" for="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                        Absent
                    </label>
                    {{--                        <button type="submit" class="btn btn-primary">Save</button>--}}
                </form>
            </div>
            @if($client->Codecli == 0)
                <div class="col-3 col-md-2">
                    <a href="{{ route('admin.PropertyEdit', ['Codecli' => $client->Codecli, 'appartement_id' => $immeuble_id]) }}" class="text-decoration-none btn btn-primary">Modifier Appartement</a>

                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function submitForm(id) {
        document.getElementById('absentForm_' + id).submit();
        console.log('absentForm_' + id);
    }
</script>
