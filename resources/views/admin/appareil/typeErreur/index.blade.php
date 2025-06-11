@extends('admin.base')

@section('title', 'Type Erreur')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.typeErreur.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>Type Erreur </th>
            <th>Appareils</th>
            <th>Actions</th>

        </tr>
        </thead>
        <tbody>
        @foreach($typeErreurs as $typeErreur)
            <tr>
                <td>{{ $typeErreur->id }}</td>
                <td>{{ $typeErreur->nom}}</td>
                <td>{{ $typeErreur->appareil}}</td>
                <td>
                    <a href="{{ route('admin.typeErreur.edit', $typeErreur->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.typeErreur.destroy', $typeErreur->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger " onclick="return confirm('Voulez-vous vraiment supprimer ce type d\'erreur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $typeErreurs->links() }}
@endsection
