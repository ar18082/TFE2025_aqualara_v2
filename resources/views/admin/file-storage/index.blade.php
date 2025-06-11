@extends('admin.base')

@section('title', 'File Storage')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.file_storage.create') }}" class="btn btn-primary">Ajouter</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>File Name</th>
            <th>path</th>
            <th>extension</th>
            <th>mime_type</th>
            <th>size</th>
            <th>created_at</th>
{{--            <th>updated_at</th>--}}
            <th>Users</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fileStorages as $file_storage)
            <tr>
                <td>{{ $file_storage->id }}</td>
                <td>{{ $file_storage->filename }}</td>
                <td>{{ $file_storage->path }}</td>
                <td>{{ $file_storage->extension }}</td>
                <td>{{ $file_storage->mime_type }}</td>
                <td>{{ $file_storage->size }}</td>
                <td>{{ $file_storage->created_at }}</td>
{{--                <td>{{ $file_storage->updated_at }}</td>--}}
                <td>{{ $file_storage->users }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.file_storage.edit', $file_storage->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.file_storage.destroy', $file_storage->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce fichier (upload) ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $fileStorages->links() }}


@endsection
