@extends('admin.base')

@section('title', $typeEvent->exists ? 'Modifier Type intervention' : 'Ajouter un Type intervention')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.typeEvent.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $typeEvent->exists ? route('admin.typeEvent.update', $typeEvent->id) : route('admin.typeEvent.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($typeEvent->exists)
            @method("PUT")
        @endif
        <div class="row">
            <div class="col">
                <div class="mb-3 row">

                    <div class="col-6">
                        @include('shared.input', ['label' => 'Nom', 'name' => 'name', 'value' => $typeEvent->name])
                        @include('shared.input', ['label' => 'abreviation', 'name' => 'abreviation', 'value' => $typeEvent->abreviation])


                    </div>


                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-25">
            @if($typeEvent->exists)
                Modifier
            @else
                Ajouter
            @endif
        </button>
    </form>
@endsection
