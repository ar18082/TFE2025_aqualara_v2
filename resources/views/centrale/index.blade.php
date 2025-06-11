@extends('base')

@section('title', 'Centrale - Liste')

@section('content')

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Codecli</th>
                <th>nom</th>
                <th>rue</th>
                <th></th>
                <th></th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->rue}}</td>
                    <td></td>
                    <td></td>
                    <td class="text-end">
                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">
                            <a href="{{route('centrales.detail', ['id'=>$client->id ])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

            <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">
                <div class="col-3 col-sm-5 col-md-5 order-1 mt-1" >


                </div>




            </div>


@endsection
