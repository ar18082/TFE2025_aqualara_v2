@extends('admin.base')

@section('title', $fileStorage->exists ? "Modifier un fichier (upload)" : "Ajouter un fichier (upload)")

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.file_storage.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <hr>

    <form action="{{ $fileStorage->exists ? route('admin.file_storage.update', $fileStorage->id) : route('admin.file_storage.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($fileStorage->exists)
    @method("PUT")
    @endif
        <div class="row">
            <div class="col-6">

    @include('shared.input_file', ['label' => 'Fichiers', 'name' => 'files', 'placeholder' => 'Fichiers', 'value' => old('file', $fileStorage->file), 'multiple' => 'multiple'])

{{--    @include('shared.input', ['label' => 'File Name', 'name' => 'filename', 'placeholder' => 'File Name', 'value' => old('filename', $fileStorage->filename)])--}}

{{--    @include('shared.input', ['label' => 'Path', 'name' => 'path', 'placeholder' => 'Path', 'value' => old('path', $fileStorage->path)])--}}

{{--    @include('shared.input', ['label' => 'Extension', 'name' => 'extension', 'placeholder' => 'Extension', 'value' => old('extension', $fileStorage->extension)])--}}

{{--    @include('shared.input', ['label' => 'Mime Type', 'name' => 'mime_type', 'placeholder' => 'Mime Type', 'value' => old('mime_type', $fileStorage->mime_type)])--}}

{{--    @include('shared.input', ['label' => 'Size', 'name' => 'size', 'placeholder' => 'Size', 'value' => old('size', $fileStorage->size), 'type' => 'number'])--}}

{{--    @include('shared.input', ['label' => 'Hash', 'name' => 'hash', 'placeholder' => 'Hash', 'value' => old('hash', $fileStorage->hash)])--}}

    @include('shared.textarea', ['label' => 'Description', 'name' => 'description', 'placeholder' => 'description', 'value' => old('description', $fileStorage->description)])

{{--    @include('shared.input', ['label' => 'Created At', 'name' => 'created_at', 'placeholder' => 'Created At', 'value' => old('created_at', $fileStorage->created_at)])--}}

{{--    @include('shared.input', ['label' => 'Updated At', 'name' => 'updated_at', 'placeholder' => 'Updated At', 'value' => old('updated_at', $fileStorage->updated_at)])--}}

{{--    @include('shared.input', ['label' => 'Users', 'name' => 'users', 'placeholder' => 'Users', 'value' => old('users', $fileStorage->users)])--}}



</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary w-25">
        @if ($fileStorage->exists)
            Modifier
        @else
            Ajouter
        @endif
    </button>
</div>

</div>


</form>



@endsection
