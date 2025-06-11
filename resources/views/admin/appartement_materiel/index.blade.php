@extends('base')
@section('title', 'Appartement_materiel')


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{route('appartementMateriel.create')}}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>

            <th>Nom</th>
            <th>Genre</th>
            <th>Type</th>
            <th>Dimension</th>
            <th>Communication</th>
            <th>Modèle</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
{{--        @foreach($appareils as $appareil)--}}
{{--            <tr>--}}
{{--                <td>{{ $appareil->nom }}</td>--}}
{{--                <td>{{ $appareil->genre }}</td>--}}
{{--                <td>{{ $appareil->type}}</td>--}}
{{--                <td>{{ $appareil->dimension}}</td>--}}
{{--                <td>{{ $appareil->communication}}</td>--}}
{{--                <td>{{ $appareil->model}}</td>--}}
{{--                <td class="text-end">--}}

{{--                    <form action="{{ route('admin.appareil.destroy', $appareil->id) }}" method="POST" class="d-inline">--}}
{{--                        @csrf--}}
{{--                        @method("DELETE")--}}
{{--                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')">Supprimer</button>--}}
{{--                    </form>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
        </tbody>

    </table>

{{--    {{ $appareils->links() }}--}}
@endsection
