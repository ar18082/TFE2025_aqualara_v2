@extends('admin.base')

@section('title', 'Sync Data: ' . $dataName . ' - Done')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Sync Data: {{ $dataName }} <span class="badge bg-success rounded-pill fw-bold">Done</span></h2>

                <hr>
                <p>Sync data from the MS SQL Server to the MariaDB database.</p>


                <div class="text-center mx-auto">
                    <ul class="list-group w-50">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Item Created :
                            <span class="badge bg-primary rounded-pill fw-bold">{{ $itemInsert }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Item Updated :
                            <span class="badge bg-primary rounded-pill">{{ $itemUpdate }} </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Item Unchanged :
                            <span class="badge bg-primary rounded-pill">{{ $itemUnchanged }} </span>
                        </li>
    {{--                    <li><hr></li>--}}
                        <li class="list-group-item d-flex justify-content-between align-items-center active">
                            <span class="fw-bold">Total Item : </span>
                            <span class="badge bg-white rounded-pill text-primary">{{ $itemTotal }} </span>
                        </li>
                    </ul>
                </div>

                    <hr>
                    <a href="{{ route('admin.sync.index') }}" class="btn btn-primary">Back</a>
                </div>



        </div>
    </div>
@endsection
