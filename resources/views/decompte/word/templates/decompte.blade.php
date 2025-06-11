@extends('decompte.word.templates.base')

@section('title', 'Décompte Individuel')

@section('header')
    <div class="row">
        <div class="col-md-3">
           <small class="row">
                <div class="col-md-12 text-left">
                    AQUATEL
                </div>
                <div class="col-md-12 text-left">
                    Rue de la Chapelle, 131
                </div>
                <div class="col-md-12 text-left">
                4800 - Verviers
                </div>
            
            </small>
        
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-3 text-right">
            <small class="row">
                <div class="col-md-12">
                  Tel : 087/35.53.62
                </div>
                <div class="col-md-12">
                    E-mail : aqua@aquatel.be
                </div>            
            </small>
        </div>
    </div>
@endsection

@section('content')
   <div class="row">
    <div class="col-md-12 container_title">
        <h1>Décompte individuel appartement</h1>
    </div>
    <div class="col-md-12 container_immeuble">
        <div class="row">
            <div class="col-md-1">
                <h2>Immeuble : test</h2>
            </div>
            <div class="col-md-1 mt-4 container_code" >
                <h2>CODE : 1234567890</h2>
            </div>
        </div>
    </div>
   </div>
@endsection

@section('footer')
    <p>Document généré automatiquement</p>
    <p>Page 1/1</p>
@endsection  