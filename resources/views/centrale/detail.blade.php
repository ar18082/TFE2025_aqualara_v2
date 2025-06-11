@extends('base')

@section('title', 'Centrale - Liste')

@section('content')
    {{--Via l'api il faut faire transiter les datas notament les numéros des centrale --}}
    <div class="row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex bg-primary rounded-1 d-sm-flex d-md-flex py-2">
        <div class="col-1 col-md-0 col-sm-0 ">ICONE</div>
        <div class="col-2 col-md-1 col-sm-2">SN/EUID</div>
        <div class="col-2 col-md-2 col-sm-2">NAME</div>
        <div class="col-2 col-md-2 col-sm-2">ICCID</div>
        <div class="col-2 col-md-1 col-sm-1">SIM CARD</div>
        <div class="col-2 col-md-1 col-sm-1">Manufactureur</div>
        <div class="col-2 col-md-2 col-sm-2">Status</div>
        {{--<div class="col-3 col-md-2 col-sm-2">ACTION</div>--}}
    </div>
    @foreach($gateways as $gateway)
    <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-light pb-2 pb-md-0">
        <div class="col-0 col-md-0 col-sm-1 my-auto order-0 order-md-0">
            <div class="bg-success rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                <i class="fa-regular fa-router mx-auto my-auto"></i>
            </div>
        </div>

            <div class="col-1 col-md-1 col-sm-1 my-auto order-1 order-md-1">{{$gateway['serialNumber']}}</div>
            <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">Gateway_{{$gateway['serialNumber']}}_{{$gateway['manufacturer']}}</div>
            <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">89882280666067667927</div>
            <div class="col-1 col-md-1 col-sm-1 my-auto order-4 order-md-5">NONE</div>
            <div class="col-1 col-md-1 col-sm-1 my-auto order-5 order-md-5">{{$gateway['manufacturer']}}</div>
            <div class="col-1 col-md-1 col-sm-1 my-auto order-6 order-md-5">{{$gateway['status']}}</div>





    </div>
    @endforeach


@endsection

