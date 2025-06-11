@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Modifier le Document</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('word.update') }}">
                        @csrf
                        
                        @foreach($tables as $index => $table)
                            <div class="table-responsive mb-4">
                                <h4>Tableau {{ $index + 1 }}</h4>
                                <table class="table table-bordered">
                                    @foreach($table->getRows() as $row)
                                        <tr>
                                            @foreach($row->getCells() as $cell)
                                                <td>
                                                    @foreach($cell->getElements() as $element)
                                                        @if(get_class($element) === 'PhpOffice\PhpWord\Element\Text')
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   name="table_{{ $index }}_cell_{{ $loop->index }}" 
                                                                   value="{{ $element->getText() }}">
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Prévisualiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 