@extends('admin.base')

@section('title', $appartementMateriel->exists ? 'Modifier l\'assignation du materiel ' : 'assigné du materiel à un appartement')
@section('content')

        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <a href="{{ route('appartementMateriel.index') }}" class="btn btn-secondary">Retour</a>
        </div>

        <form
            action="{{ $appartementMateriel->exists ? route('appartementMateriel.update', $appartementMateriel->id) : route('appartementMateriel.store') }}"
            method="POST" class="mt-5">
            @csrf
            @if($appartementMateriel->exists)
                @method("PUT")
            @endif
            <div class="row">
                <div class="col-12 row m-2">
                    <div class="col-4 text start">

                    </div>
                </div>
            </div>
        </form>
@endsection
