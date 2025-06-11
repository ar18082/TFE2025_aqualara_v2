@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Document Word</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('word.process') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="word_file">Sélectionnez votre fichier Word</label>
                            <input type="file" class="form-control-file" id="word_file" name="word_file" accept=".docx">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 