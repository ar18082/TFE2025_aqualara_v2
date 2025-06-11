@extends('base')

@section('content')
    <div class="container">
        <h1>Liste des Utilisateurs</h1>
        <a href="{{route('admin.user.create')}}" class="btn btn-primary mb-2">Ajouter</a>
        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
