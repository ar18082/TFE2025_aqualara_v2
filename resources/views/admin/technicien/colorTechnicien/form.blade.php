
@extends('admin.base')

@section('title', $color->exists ? 'Modifier la couleur ' : 'Ajouter une couleur')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.couleurTechnicien.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $color->exists ? route('admin.couleurTechnicien.update', $color->id) : route('admin.couleurTechnicien.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($color->exists)
            @method("PUT")
            <h1>coucou</h1>
        @endif
        <div class="row">
            <div class="col">
                <div class="mb-3 row">
                    <div class="col-6">
                        <input type="hidden" name="color_id" value="{{ $color->id }}">
                        @include('shared.input', ['label' => 'Couleur', 'name' => 'couleur', 'value' => $color->couleur])
                        @include('shared.input', ['label' => 'Code Hexadecimal', 'name' => 'code_hexa', 'value' => $color->code_hexa])

                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-25">
            @if($color->exists)
                Modifier
            @else
                Ajouter
            @endif
        </button>
    </form>
@endsection
