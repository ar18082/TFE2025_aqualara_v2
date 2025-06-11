@extends('base')
@section('title', 'Materiels')


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.materiel.create') }}" class="btn btn-primary">Ajouter</a>
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
        @foreach($materiels as $materiel)
            <tr>
                <td>{{ $materiel->nom }}</td>
                <td>{{ $materiel->genre }}</td>
                <td>{{ $materiel->type}}</td>
                <td>{{ $materiel->dimension}}</td>
                <td>{{ $materiel->communication}}</td>
                <td>{{ $materiel->model}}</td>
                <td class="text-end">

                    <form action="{{ route('admin.materiel.destroy', $materiel->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $materiels->links() }}
@endsection
