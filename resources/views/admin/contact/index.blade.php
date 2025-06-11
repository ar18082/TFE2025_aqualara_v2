@extends('admin.base')

@section('title', 'Contact')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.contact.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Code Gerant</th>
                <th>nom</th>
                <th>rue</th>
                <th>tel</th>
                <th>Email</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->codunique }}</td>
                    <td>{{ $contact->nom }}</td>
                    <td>{{ $contact->rue}}, {{$contact->boite}}</td>
                    <td>{{ $contact->tel }}</td>
                    <td>{{ $contact->email1 }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.contact.edit', $contact->id) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce propriétaire ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{ $contacts->links() }}
@endsection
