@extends('base')
@section('title', 'Type intervention')


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.typeEvent.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>

            <th>Nom</th>
            <th>Abreviation</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($typeEvents as $typeEvent)
            <tr>
                <td>{{ $typeEvent->name }}</td>
                <td>{{ $typeEvent->abreviation }}</td>

                <td class="text-end">
                    <a href="{{ route('admin.typeEvent.edit', $typeEvent->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.typeEvent.destroy', $typeEvent->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce type d\'évenement ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $typeEvents->links() }}
@endsection
