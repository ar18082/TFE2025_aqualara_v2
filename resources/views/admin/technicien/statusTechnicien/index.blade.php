@extends('admin.base')

@section('title', 'Status Technicien')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.statusTechnicien.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statusTechniciens as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->nom}}</td>
                <td>
                    <a href="{{ route('admin.statusTechnicien.edit', $status->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.statusTechnicien.destroy', $status->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger " onclick="return confirm('Voulez-vous vraiment supprimer ce status ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $statusTechniciens->links() }}
@endsection
