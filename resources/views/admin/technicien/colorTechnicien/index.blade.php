@extends('admin.base')

@section('title', 'Couleur')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.couleurTechnicien.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>color</th>
            <th>Couleur</th>
            <th>Code hexadecimal</th>
            <th>disponible</th>
        </tr>
        </thead>
        <tbody>
        @foreach($colors as $color)
            <tr>
                <td>
                    <div style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $color->code_hexa }};"></div>
                </td>
                <td>{{ $color->couleur}}</td>
                <td>{{ $color->code_hexa}}</td>
                <td>{{ $color->dispo ? 'Oui' : 'Non' }}</td>
                <td>
                    <a href="{{ route('admin.couleurTechnicien.edit', $color->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.couleurTechnicien.destroy', $color->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger " onclick="return confirm('Voulez-vous vraiment supprimer cette couleur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $colors->links() }}
@endsection
