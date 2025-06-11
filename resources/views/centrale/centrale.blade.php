@extends('base')

@section('title', 'Centrale - Liste')

@section('content')
<div class="row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex bg-primary rounded-1 d-sm-flex d-md-flex py-2">
    <div class="col-1 col-md-1 col-sm-0 ">ICONE</div>
    <div class="col-2 col-md-2 col-sm-2">SN/EUID</div>
    <div class="col-2 col-md-2 col-sm-2">NAME</div>
    <div class="col-2 col-md-2 col-sm-2">ICCID</div>
    <div class="col-2 col-md-2 col-sm-2">SIM CARD</div>
    <div class="col-3 col-md-3 col-sm-2">ACTION</div>
</div>
<div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-light pb-2 pb-md-0">
    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">
        <div class="bg-success rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
            <i class="fa-regular fa-router mx-auto my-auto"></i>
        </div>
    </div>

    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">11111</div>
    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">Gateway_30545061_SON</div>
    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">89882280666067667927</div>
    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">NONE</div>
    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">
        <div class="col-3 col-sm-5 col-md-5 order-1 mt-1" >
            <div style="display: block">

                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">
                    <a href="#" class="btn btn-primary"> <i class="fa-regular fa-pen"></i></a>

                </div>
            </div>

        </div>


        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">
            <a href="{{route('centrales.detail', ['id'=>1])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>
        </div>

    </div>
</div>

@endsection

