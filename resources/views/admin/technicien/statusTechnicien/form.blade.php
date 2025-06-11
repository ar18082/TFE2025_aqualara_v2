
@extends('admin.base')

@section('title', $s_Technicien->exists ? 'Modifier le status technicien' : 'Ajouter un status technicien')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.statusTechnicien.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <form action="{{ $s_Technicien->exists ? route('admin.statusTechnicien.update', $s_Technicien->id) : route('admin.statusTechnicien.store') }}"
          method="POST" class="mt-5">
        @csrf
        @if($s_Technicien->exists)
            @method("PUT")
        @endif
        <div class="row">
            <div class="col">
                <div class="mb-3 row">
                    <div class="col-6">
                        @include('shared.input', ['label' => 'Nom', 'name' => 'nom', 'value' => $s_Technicien->nom])

                    </div>
                    <div class="col-6"></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-25">
            @if($s_Technicien->exists)
                Modifier
            @else
                Ajouter
            @endif
        </button>
    </form>
@endsection
