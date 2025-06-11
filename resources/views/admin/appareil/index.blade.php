@extends('base')
@section('title', 'Appareils')


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.appareil.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>codeCli</th>
            <th>RefAppTR</th>
            <th>numSerie</th>
            <th>TypeReleve</th>
            <th>coef</th>
            <th>sit</th>
            <th>TypeMateriel</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appareils as $appareil)
            <tr>
                <td>{{ $appareil->codeCli }}</td>
                <td>{{ $appareil->RefAppTR }}</td>
                <td>{{ $appareil->numSerie}}</td>
                <td>{{ $appareil->TypeReleve}}</td>
                <td>{{ $appareil->coef}}</td>
                <td>{{ $appareil->sit}}</td>
                <td>{{ $appareil->materiel->nom ?? ''}}</td>
                <td class="text-end">
                    <a href="{{ route('admin.appareil.edit', $appareil->id) }}" class="btn btn-warning">Modifier</a>

                    <form action="{{ route('admin.appareil.destroy', $appareil->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet appareil ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $appareils->links() }}
@endsection
