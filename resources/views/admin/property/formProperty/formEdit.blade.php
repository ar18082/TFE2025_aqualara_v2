@extends('admin.base')

@section('title',  "Modifier une propriété" )

@section('content')
    <div id="successMessage"></div>
    <div class="d-flex justify-content-between align-items-center">
        <h1 id="title">@yield('title')</h1>
        <a href="{{route('immeubles.showAppartement', ['Codecli_id' => $client[0]->appartements[0]->Codecli, 'appartement_id'=>$client[0]->appartements[0]->RefAppTR])}}" class="btn btn-secondary">Retour</a>
    </div>

    <hr>

    <form action="{{route('immeubles.PropertyUpdate', ['Codecli' => $client[0]->appartements[0]->Codecli, 'appartement_id'=>$client[0]->appartements[0]->RefAppTR])}}" method="POST">
        @csrf
{{--        @method('PUT')--}}

        <div class="row mt-2">
            {{--@include('admin.property.formProperty.nbrPropertyForm')--}}
            @include('admin.property.formProperty.propertyForm')
            {{-- <input type="hidden" id='propertyID' name="propertyID" value="{{ $property->id }}"> --}}
            {{-- <div class="mt-3"> --}}
            {{-- <button type="button" id='submitForm' class="btn btn-primary w-25" style="display: none"> --}}
            {{-- </button> --}}
            {{-- </div> --}}
            <h3 class="mt-4">Appareils </h3>
            <table class="table">
                <thead>
                <tr class="row">
                    <th scope="col" class="col-2">N° Série</th>
                    <th scope="col" class="col-2">Type</th>
                    <th scope="col" class="col-1">N° Rad</th>
                    <th scope="col" class="col-2">Situation</th>
                    <th scope="col" class="col-2">Coefficient</th>
                    <th scope="col" class="col-2">Matériel</th>
                    <th scope="col" class="col-1">Actif</th>
                </tr>
                </thead>
                <tbody id="tbody">
                @foreach($client[0]->appareils as $appareil)
                    <tr id="row_cal" class="row">
                        <td class="col-2"><input type="text" class="form-control" id="serialNumber_{{$appareil->numSerie}}" name="serialNumber_{{$appareil->numSerie}}" value="{{$appareil->numSerie}}"></td>
                        <td class="col-2"><input type="text" class="form-control" id="type_{{$appareil->numSerie}}" name="type_{{$appareil->numSerie}}" value="{{$appareil->TypeReleve}}"></td>
                        <td class="col-1"><input type="text" class="form-control" id="numero_{{$appareil->numSerie}}" name="numero_{{$appareil->numSerie}}" value="{{$appareil->numero}}"></td>
                        <td class="col-2"><input type="text" class="form-control" id="situation_{{$appareil->numSerie}}" name="situation_{{$appareil->numSerie}}" value="{{$appareil->sit}}"></td>
                        <td class="col-2"><input type="text" class="form-control" id="coefficient_{{$appareil->numSerie}}" name="coefficient_{{$appareil->numSerie}}" value="{{$appareil->coef}}"></td>
                        <td class="col-2"><select class="form-control materiel col-5" name="materiel_id_{{$appareil->numSerie}}"></select></td>
                        <td class="col-1">
                            <div class="form-check form-switch">
                                @if($appareil->appareilsErreurs->isEmpty())
                                    @php($checked = 'checked')
                                @else
                                    @php($checked = '')
                                @endif
                                <input class="form-check-input" type="checkbox" role="switch" id="actif_{{$appareil->numSerie}}" name="actif_{{$appareil->numSerie}}" {{$checked}}>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-11"></div>
                <button type="button" id='addRow' class="btn btn-primary col-1">
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </div>

            <div class="mt-3">
                <button type="submit" id='submit' class="btn btn-primary w-25 col-md-5">
                    Modifier
                </button>
            </div>
        </div>
    </form>
@endsection

