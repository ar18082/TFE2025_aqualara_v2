@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Prévisualisation du Document</div>

                <div class="card-body">
                    <div class="mb-4">
                        <iframe src="{{ route('word.view', ['file' => $file_path]) }}" 
                                style="width: 100%; height: 600px; border: 1px solid #ddd;">
                        </iframe>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('word.edit') }}" class="btn btn-secondary">Modifier</a>
                        <form method="POST" action="{{ route('word.convert') }}">
                            @csrf
                            <input type="hidden" name="file_path" value="{{ $file_path }}">
                            <button type="submit" class="btn btn-success">Convertir en PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 